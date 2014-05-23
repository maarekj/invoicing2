<?php

namespace Jma\BootstrapBundle\Filter\Event;

use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Lexik\Bundle\FormFilterBundle\Event\ApplyFilterEvent;

/**
 * Description of DoctrineSubscriber
 *
 * @author Maarek
 * 
 * @DI\Service
 * @DI\Tag("kernel.event_subscriber")
 */
class DoctrineSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            'lexik_form_filter.apply.orm.filter_month' => array('filterMonth'),
        );
    }

    public function filterMonth(ApplyFilterEvent $event)
    {
        $qb = $event->getQueryBuilder(); /* @var $qb QueryBuilder */
        $expr = $event->getFilterQuery()->getExpressionBuilder();
        $values = $event->getValues();
        $value = $values['value'];

        $now = new \DateTime();
        $m = isset($value['month']) ? $value['month'] : null;
        $y = isset($value['year']) ? $value['year'] : (int) $now->format('Y');

        if ($m !== null) {
            $fromDate = \DateTime::createFromFormat('Y-n-j', sprintf('%s-%s-1', $y, $m));
            $fromDate->setTime(0, 0, 0);

            $toDate = \DateTime::createFromFormat('Y-n-j', sprintf('%s-%s-1', $y, $m));
            $toDate->setTime(0, 0, 0);
            $toDate->add(new \DateInterval('P1M'));
            $interval = new \DateInterval('PT1S');
            $interval->invert = 1;
            $toDate->add($interval);

            if ($fromDate instanceof \DateTime && $toDate instanceof \DateTime) {
                $qb->andWhere($expr->dateTimeInRange($event->getField(), $fromDate, $toDate));
            }
        }
    }

}


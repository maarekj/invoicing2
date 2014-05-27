<?php

namespace Jma\Invoicing\AppBundle\Filter;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation\FormType;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

/**
 * @FormType
 */
class InvoiceFilter extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', 'filter_text', array(
                'condition_pattern' => FilterOperands::STRING_BOTH
            ))
            ->add('client', 'filter_entity', array(
                'required' => false,
                'class' => 'InvoicingAppBundle:Client',
                'property' => 'name',
                'label' => 'Client',
            ))
            ->add('tags', 'filter_entity', array(
                'class' => 'InvoicingAppBundle:Tag',
                'multiple' => true,
                'property' => 'label',
                'label' => 'Tags',
                'apply_filter' => array($this, 'filterTags')
            ))
            ->add('created', 'filter_month', array(
                'label' => 'Crée'
            ))
            ->add('updated', 'filter_month', array(
                'label' => 'Modifié'
            ));
    }

    public function filterTags(QueryInterface $query, $field, $value)
    {
        /** @var QueryBuilder $q */
        $q = $query->getQueryBuilder();

        if (count($value['value']) > 0) {
            $ids = $value['value']->map(function ($o) {
                return $o->getId();
            })->toArray();
            $alias = $value['alias'] . '_l';

            $q->innerJoin($field, $alias, Join::WITH, $q->expr()->in($alias . '.id', $ids));
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'validation_groups' => array('filtering')
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'invoicing_invoice_filter';
    }

}

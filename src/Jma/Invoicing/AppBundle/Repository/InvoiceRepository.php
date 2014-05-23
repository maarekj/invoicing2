<?php

namespace Jma\Invoicing\AppBundle\Repository;

use Jma\ResourceBundle\Repository\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\QueryBuilder;

class InvoiceRepository extends EntityRepository implements ContainerAwareInterface
{
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return EntrepreneurRepository
     */
    public function getEntrepreneurRepository()
    {
        return $this->container->get('invoicing.repository.entrepreneur');
    }

    /**
     * {@inheritdoc}
     */
    protected function applyCriteria(QueryBuilder $queryBuilder, array $criteria = null)
    {
        $criteria = $this->getEntrepreneurRepository()->criteriaCurrentEntrepreneur($criteria);
        parent::applyCriteria($queryBuilder, $criteria);
    }
}

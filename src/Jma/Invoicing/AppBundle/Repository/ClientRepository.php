<?php

namespace Jma\Invoicing\AppBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Jma\ResourceBundle\Repository\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ClientRepository extends EntityRepository implements ContainerAwareInterface
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
     * @return QueryBuilder
     */
    public function builderAllRestrictByCurrentEntrepreneur()
    {
        return $this->builderAll(array('current_entrepreneurs' => true));
    }

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @param array $criteria
     */
    protected function applyCriteria(QueryBuilder $queryBuilder, array $criteria = null)
    {
        $criteria = $this->getEntrepreneurRepository()->criteriaCurrentEntrepreneurs($queryBuilder, $criteria, $this->getAlias());
        parent::applyCriteria($queryBuilder, $criteria);
    }

    protected function getAlias()
    {
        return "client";
    }
}

<?php

namespace Jma\Invoicing\AppBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Jma\ResourceBundle\Repository\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TagRepository extends EntityRepository implements ContainerAwareInterface
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
        return $this->builderAll(array('current_entrepreneur' => true));
    }

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @param array $criteria
     */
    protected function applyCriteria(QueryBuilder $queryBuilder, array $criteria = null)
    {
        $criteria = $this->getEntrepreneurRepository()->criteriaCurrentEntrepreneur($criteria);
        parent::applyCriteria($queryBuilder, $criteria);
    }
}

<?php

namespace Jma\Invoicing\AppBundle\Repository;

use Doctrine\ORM\Query;
use Jma\ResourceBundle\Repository\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\QueryBuilder;

class InvoiceRepository extends EntityRepository implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return \Jma\Invoicing\AppBundle\Security\User\User
     */
    public function getUser()
    {
        return $this->container->get("security.context")->getToken()->getUser();
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

    public function getNextNumber()
    {
        $currentEntrepreneur = $this->getUser()->getEntrepreneur();
        $builder = $this->getQueryBuilder();
        $o = $this->getAlias();
        if ($currentEntrepreneur != null) {
            $builder->where("$o.entrepreneur = :entrepreneur")->setParameter("entrepreneur", $currentEntrepreneur);
        }

        $maxNumber = $builder
            ->select("MAX($o.number) as max_number")
            ->getQuery()
            ->getSingleScalarResult() ? : 0;

        return $maxNumber + 1;
    }

    public function getAlias()
    {
        return "invoice";
    }
}

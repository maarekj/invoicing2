<?php

namespace Jma\Invoicing\AppBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Jma\Invoicing\AppBundle\Entity\Entrepreneur;
use Jma\ResourceBundle\Repository\EntityRepository;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EntrepreneurRepository extends EntityRepository implements ContainerAwareInterface
{
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return SecurityContextInterface
     */
    public function getSecurity()
    {
        return $this->container->get('security.context');
    }

    /**
     * @return \Jma\Invoicing\AppBundle\Security\User\User
     */
    public function getUser()
    {
        return $this->getSecurity()->getToken()->getUser();
    }

    /**
     * @return QueryBuilder|null
     */
    public function builderAllRestrict()
    {
        return $this->restrictBuilder($this->getCollectionQueryBuilder());
    }

    /**
     * @param QueryBuilder $builder
     * @return QueryBuilder|null
     */
    public function restrictBuilder(QueryBuilder $builder)
    {
        if (true === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
            return $builder;
        } elseif ($this->getSecurity()->isGranted('ROLE_ENTREPRENEUR')) {
            $currentEntrepreneur = $this->getUser()->getEntrepreneur();
            if ($currentEntrepreneur != null) {
                $builder
                    ->andWhere('entrepreneur.id = :id')
                    ->setParameter('id', $currentEntrepreneur->getId());
            } else {
                $builder->andWhere("1 = 0");
            }
        } else {
            $builder->andWhere("1 = 0");
        }

        return $builder;
    }

    public function criteriaCurrentEntrepreneur(array $criteria = null, $field = 'entrepreneur')
    {
        if ($criteria !== null) {
            if (array_key_exists('current_entrepreneur', $criteria) && true === $criteria['current_entrepreneur']) {
                if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {
                    $criteria[$field] = $this->getUser()->getEntrepreneur();
                }
            }

            unset($criteria['current_entrepreneur']);
        }

        return $criteria;
    }

    public function criteriaCurrentEntrepreneurs(QueryBuilder $queryBuilder, array $criteria = null, $alias, $field = 'entrepreneurs')
    {
        if ($criteria !== null) {
            if (array_key_exists('current_entrepreneurs', $criteria) && true === $criteria['current_entrepreneurs']) {
                if (false === $this->getSecurity()->isGranted('ROLE_ADMIN')) {

                    $entrepreneur = $this->getUser()->getEntrepreneur()->getId();

                    $queryBuilder->innerJoin("$alias.$field", $this->getAlias())
                        ->andWhere($queryBuilder->expr()->in($this->getPropertyName('id'), $entrepreneur));
                }
            }

            unset($criteria['current_entrepreneurs']);
        }

        return $criteria;
    }

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @param array $criteria
     */
    protected
    function applyCriteria(QueryBuilder $queryBuilder, array $criteria = null)
    {
        if ($criteria !== null && array_key_exists('current_entrepreneur', $criteria) && true === $criteria['current_entrepreneur']) {
            $queryBuilder = $this->restrictBuilder($queryBuilder);
            unset($criteria['current_entrepreneur']);
        }

        parent::applyCriteria($queryBuilder, $criteria);
    }

    protected
    function getAlias()
    {
        return "entrepreneur";
    }


}

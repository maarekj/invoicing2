<?php

namespace Jma\Invoicing\AppBundle\Menu;

use Symfony\Component\DependencyInjection\ContainerAware;
use Knp\Menu\FactoryInterface;
use Jma\Invoicing\AppBundle\Security\User\User;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @author Maarek
 */
class MenuBuilder extends ContainerAware
{

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'navbar' => true,
        ));

        if ($this->getSecurity()->isGranted('IS_AUTHENTICATED_FULLY')) {

            $menu->addChild('Factures', array('route' => 'invoicing_invoice_index'));
            $menu->addChild('Clients', array('route' => 'invoicing_client_index'));
            $menu->addChild('Entrepreneurs', array('route' => 'invoicing_entrepreneur_index'));
            $menu->addChild('Tags', array('route' => 'invoicing_tag_index'));
        }

        return $menu;
    }

    public function mainMenuRight(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'navbar' => true,
            'pull-right' => true
        ));

        if ($this->getSecurity()->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->getSecurity()->getToken()->getUser(); /* @var $user User */
            $entrepreneur = $user->getEntrepreneur();

            if ($entrepreneur !== null) {
                $label = sprintf('Bonjour %s %s, se déconnecter ?'
                        , $entrepreneur ->getLastname()
                        , $entrepreneur ->getFirstname());
                $menu->addChild($label, array('route' => 'invoicing_security_logout'));
            } else {
                $menu->addChild('Déconnecter', array('route' => 'invoicing_security_logout'));
            }
        }

        return $menu;
    }

    /**
     * @return SecurityContextInterface
     */
    public function getSecurity()
    {
        return $this->container->get('security.context');
    }

}

<?php

namespace Jma\Invoicing\AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class InvoicingAppExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('form.yml');
        
        $users = isset($config['users']) ? $config['users'] : array();
        $container->setParameter('invoicing_user_provider.users', $users);

        $this->addClassesToCompile([
            'Jma\Invoicing\AppBundle\Controller\DefaultController',
            'Jma\Invoicing\AppBundle\Controller\InvoiceController',
            'Jma\Invoicing\AppBundle\Controller\SecurityController',
            'Jma\Invoicing\AppBundle\Repository\ClientRepository',
            'Jma\Invoicing\AppBundle\Repository\EntrepreneurRepository',
            'Jma\Invoicing\AppBundle\Repository\InvoiceRepository',
            'Jma\Invoicing\AppBundle\Repository\TagRepository',
            'Jma\Invoicing\AppBundle\Security\User\User',
            'Jma\Invoicing\AppBundle\Form\ClientType',
            'Jma\Invoicing\AppBundle\Form\EntrepreneurType',
            'Jma\Invoicing\AppBundle\Form\InvoiceLineCollectionType',
            'Jma\Invoicing\AppBundle\Form\InvoiceLineType',
            'Jma\Invoicing\AppBundle\Form\InvoiceType',
            'Jma\Invoicing\AppBundle\Form\PaymentCollectionType',
            'Jma\Invoicing\AppBundle\Form\PaymentType',
            'Jma\Invoicing\AppBundle\Form\TagType',

        ]);
    }
}

<?php

namespace Jma\BootstrapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jma_bootstrap');

        $rootNode
            ->children()
                ->arrayNode('json')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->enumNode('pagerfanta')
                            ->values(array('full', 'default', null))
                            ->beforeNormalization()
                                ->ifNull()->then(function($v) { return 'default'; })
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
                
                

        return $treeBuilder;
    }

}

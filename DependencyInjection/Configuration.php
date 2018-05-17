<?php

namespace Gpekz\NotifierBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration.
 *
 * @author Geoffrey Pécro <geoffrey.pecro@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('gpekz_notifier');

        $rootNode
            ->children()
                ->arrayNode('default')
                    ->children()
                        ->scalarNode('from_email')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('from_name')
                            ->cannotBeEmpty()
                        ->end()
                        ->arrayNode('reply_to')
                            ->scalarPrototype()
                                ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

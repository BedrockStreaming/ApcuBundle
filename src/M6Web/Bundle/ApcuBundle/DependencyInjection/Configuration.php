<?php

declare(strict_types=1);

namespace M6Web\Bundle\ApcuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Validates and merges configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('m6web_apcu');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('alias')
            ->prototype('array')
                ->children()
                    ->scalarNode('namespace')
                        ->defaultValue('')
                    ->end()
                    ->integerNode('ttl')
                        ->defaultValue(3600)
                    ->end()
                    ->scalarNode('class')
                        ->defaultValue('M6Web\Bundle\ApcuBundle\Apcu\Apcu')
                    ->end()
                ->end();

        return $treeBuilder;
    }
}

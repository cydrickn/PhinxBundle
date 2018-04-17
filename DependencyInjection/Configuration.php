<?php

namespace Cydrickn\PhinxBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Description of Configuration
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('cydrickn_phinx');

        $rootNode
            ->children()
                ->arrayNode('paths')
                    ->children()
                        ->scalarNode('migrations')->end()
                        ->scalarNode('seeds')->end()
                    ->end()
                ->end()
                ->variableNode('environments')->end()
                ->scalarNode('version_order')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

<?php

namespace Tbmatuka\EditorjsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('editorjs');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('tools')
                    ->normalizeKeys(false)
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('url')->defaultNull()->end()
                            ->scalarNode('className')->defaultNull()->end()
                            ->scalarNode('shortcut')->defaultNull()->end()
                            ->variableNode('inlineToolbar')
                                ->defaultNull()
                                ->validate()
                                    ->ifTrue(function ($value) {
                                        return !($value === null || is_array($value) || is_bool($value));
                                    })
                                    ->thenInvalid('inlineToolbar can be either a boolean or an array')
                                ->end()
                            ->end()
                            ->arrayNode('toolbox')
                                ->children()
                                    ->scalarNode('title')->defaultNull()->end()
                                    ->scalarNode('icon')->defaultNull()->end()
                                ->end()
                            ->end()
                            ->arrayNode('config')
                                ->normalizeKeys(false)
                                ->useAttributeAsKey('name')
                                ->variablePrototype()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('configs')
                    ->normalizeKeys(false)
                    ->useAttributeAsKey('name')
                    ->variablePrototype()->end()
                ->end()
            ->end();

        return $treeBuilder;
    }

    private function createToolNode()
    {
    }

    private function createConfigNode()
    {
    }
}

<?php

namespace Lone\SystempayBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('systempay');
        $treeBuilder
            ->getRootNode()
            ->children()
            ->scalarNode('hash_method')->end()
            ->scalarNode('key_dev')->defaultNull()->end()
            ->scalarNode('key_prod')->defaultNull()->end()
            ->arrayNode('vads')->children()
                ->scalarNode('debug')->defaultValue('ON')->end()
                ->scalarNode('site_id')->isRequired()->defaultValue('xxxxx')->end()
                ->scalarNode('url_return')->isRequired()->defaultValue('https://xxxx.xxxx')->end()
                ->scalarNode('return_mode')->defaultValue('POST')->end()
                ->scalarNode('ctx_mode')->defaultValue('TEST')->end()
                ->scalarNode('page_action')->defaultValue('PAYMENT')->end()
                ->scalarNode('action_mode')->defaultValue('INTERACTIVE')->end()
                ->scalarNode('payment_config')->defaultValue('SINGLE')->end()
                ->scalarNode('version')->defaultValue('V2')->end()
                ->scalarNode('language')->defaultValue('fr')->end()
            ->end()
            ->end()
        ;

        /**
         * Do not change the following values
         * page_action: PAYMENT
         * action_mode: INTERACTIVE
         * payment_config: SINGLE
         * version: V2
         **/

        return $treeBuilder;
    }
}

<?php

namespace Tlconseil\SystempayBundle\DependencyInjection;

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
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('tlconseil_systempay');

        $rootNode
            ->children()
            ->scalarNode('debug')->defaultValue('ON')->end()
            ->scalarNode('site_id')->defaultValue('')->end()
            ->scalarNode('key_dev')->defaultValue('')->end()
            ->scalarNode('key_prod')->defaultValue('')->end()
            ->scalarNode('url_return')->defaultValue('')->end()
            ->scalarNode('return_mode')->defaultValue('')->end()
            ->scalarNode('ctx_mode')->defaultValue('TEST')->end()
            ->scalarNode('page_action')->defaultValue('PAYMENT')->end()
            ->scalarNode('action_mode')->defaultValue('INTERACTIVE')->end()
            ->scalarNode('payment_config')->defaultValue('SINGLE')->end()
            ->scalarNode('version')->defaultValue('V2')->end()
            ->scalarNode('language')->defaultValue('fr')->end()
            ->scalarNode('redirect_success_timeout')->defaultValue('1')->end()
            ->scalarNode('redirect_success_message')->defaultValue('Redirection vers la boutique dans quelques instants')->end()
            ->scalarNode('redirect_error_timeout')->defaultValue('1')->end()
            ->scalarNode('redirect_error_message')->defaultValue('Redirection vers la boutique dans quelques instants')->end()
            ->end()
        ;

        /**
         * Do not change the following values
         * page_action: PAYMENT
         * action_mode: INTERACTIVE
         * payment_config: SINGLE
         * version: V2
         **/
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}

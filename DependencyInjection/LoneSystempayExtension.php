<?php

namespace Lone\SystempayBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Symfony\Component\DependencyInjection\Loader;

class LoneSystempayExtension extends ConfigurableExtension
{

    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $this->setConfigAsParameter($mergedConfig, $container);
    }

    private function setConfigAsParameter(array $config, ContainerBuilder $container, string $prefix = null) {
        foreach ($config as $field => $value) {
            if (is_array($value)) {
                $this->setConfigAsParameter($value, $container, $field);
            } else {
                $key = sprintf('%s.%s%s', $this->getAlias(), $prefix ? $prefix.'.' : '', $field);
                $container->setParameter($key, $value);
            }
        }
    }

    function getAlias()
    {
        return 'systempay';
    }

}

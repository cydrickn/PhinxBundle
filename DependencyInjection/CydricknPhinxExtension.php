<?php

namespace Cydrickn\PhinxBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * Description of CydricknPhinxExtension
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class CydricknPhinxExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->register('cydrickn_phinx.config');
        $definition->setClass(\Phinx\Config\Config::class);
        $definition->addArgument($config);
        $definition->setPublic(true);
    }
}

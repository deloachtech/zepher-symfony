<?php
/**
 * This file is part of the deloachtech/zepher-symfony package.
 *
 * (c) DeLoach Tech, LLC
 * https://deloachtech.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DeLoachTech\ZepherBundle\DependencyInjection;

use DeLoachTech\ZepherBundle\Security\AccessControl;
use DeLoachTech\ZepherBundle\Service\AccessService;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ZepherExtension extends Extension
{

    public function getAlias(): string
    {
        return 'zepher';
    }



    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $container->getDefinition(AccessControl::class)->setArgument('$accessConfig', $config);
        $container->getDefinition(AccessService::class)->setArgument('$accessConfig', $config);

        // This extension config
//        dd($config);
    }

}
<?php

namespace Pim\Bundle\ExcelConnectorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PimExcelConnectorExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->setParameter('pim_excel_connector.root_dir', sprintf('%s/..', __DIR__));
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('iterators.yml');
        $loader->load('readers.yml');
        $loader->load('writers.yml');
        $loader->load('transformers.yml');
        $loader->load('guessers.yml');
        $loader->load('excel.yml');
        $loader->load('processors.yml');
        $loader->load('serializer.yml');
    }
}

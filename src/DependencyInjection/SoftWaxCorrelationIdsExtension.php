<?php

declare(strict_types=1);

namespace SoftWax\CorrelationIds\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class SoftWaxCorrelationIdsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $env = $container->getParameter('kernel.environment');

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config'),
            \is_string($env) ? $env : null,
        );

        try {
            $loader->load('services.yaml');
        } catch (\Exception $e) {
            throw new \LogicException(\sprintf('Failed to load %s services.yaml', $this->getAlias()), 0, $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'softwax_correlation_ids';
    }
}

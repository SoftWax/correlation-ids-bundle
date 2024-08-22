<?php

declare(strict_types=1);

namespace SoftWax\CorrelationIds\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final readonly class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('softwax_correlation_ids');
        $rootNode = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}

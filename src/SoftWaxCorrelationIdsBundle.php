<?php

declare(strict_types=1);

namespace SoftWax\CorrelationIds;

use SoftWax\CorrelationIds\DependencyInjection\SoftWaxCorrelationIdsExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SoftWaxCorrelationIdsBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (!$this->extension instanceof ExtensionInterface) {
            $this->extension = new SoftWaxCorrelationIdsExtension();
        }

        return $this->extension;
    }
}

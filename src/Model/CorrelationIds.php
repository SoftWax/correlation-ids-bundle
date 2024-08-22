<?php

declare(strict_types=1);

namespace SoftWax\CorrelationIds\Model;

final class CorrelationIds
{
    public function __construct(
        private string $currentId,
        private ?string $parentId,
        private string $rootId,
    ) {
    }

    public function replace(CorrelationIds $correlationIds): void
    {
        $this->currentId = $correlationIds->getCurrentId();
        $this->parentId = $correlationIds->getParentId();
        $this->rootId = $correlationIds->getRootId();
    }

    public function getCurrentId(): string
    {
        return $this->currentId;
    }

    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    public function getRootId(): string
    {
        return $this->rootId;
    }
}

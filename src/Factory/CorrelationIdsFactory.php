<?php

declare(strict_types=1);

namespace SoftWax\CorrelationIds\Factory;

use SoftWax\CorrelationIds\Generator\IdGeneratorInterface;
use SoftWax\CorrelationIds\Model\CorrelationIds;

final readonly class CorrelationIdsFactory
{
    public function __construct(
        private IdGeneratorInterface $idGenerator,
    ) {
    }

    public function create(
        ?string $currentId = null,
        ?string $parentId = null,
        ?string $rootId = null,
    ): CorrelationIds {
        $currentId = $currentId ?? $this->idGenerator->generate();

        return new CorrelationIds(
            $currentId,
            $parentId,
            $rootId ?? $currentId,
        );
    }
}

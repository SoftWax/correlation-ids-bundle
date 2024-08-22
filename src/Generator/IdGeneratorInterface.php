<?php

declare(strict_types=1);

namespace SoftWax\CorrelationIds\Generator;

interface IdGeneratorInterface
{
    /**
     * @return non-empty-string
     */
    public function generate(): string;
}

<?php

declare(strict_types=1);

namespace SoftWax\CorrelationIds\Storage;

use SoftWax\CorrelationIds\Model\CorrelationIds;
use Symfony\Contracts\Service\ResetInterface;

final class CorrelationIdsStorage implements ResetInterface
{
    private ?CorrelationIds $correlationIds = null;

    public function get(): CorrelationIds
    {
        if ($this->correlationIds === null) {
            $this->correlationIds = new CorrelationIds(
                'initial-value',
                null,
                'initial-value',
            );
        }

        return $this->correlationIds;
    }

    /**
     * {@inheritdoc}
     */
    public function reset(): void
    {
        unset($this->correlationIds);
        $this->correlationIds = null;
    }
}

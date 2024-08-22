<?php

declare(strict_types=1);

namespace SoftWax\CorrelationIds\Integration\Monolog;

use Monolog\Attribute\AsMonologProcessor;
use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;
use SoftWax\CorrelationIds\Storage\CorrelationIdsStorage;

#[AsMonologProcessor]
final readonly class CorrelationIdsProcessor implements ProcessorInterface
{
    public function __construct(
        private CorrelationIdsStorage $storage,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(LogRecord $record): LogRecord
    {
        $correlationIds = $this->storage->get();

        return $record->with(
            ...[
                'extra' => \array_merge(
                    $record->extra,
                    [
                        'correlation_ids' => [
                            'current' => $correlationIds->getCurrentId(),
                            'parent' => $correlationIds->getParentId(),
                            'root' => $correlationIds->getRootId(),
                        ],
                    ],
                ),
            ],
        );
    }
}

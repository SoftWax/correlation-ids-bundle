<?php

declare(strict_types=1);

namespace SoftWax\CorrelationIds\Integration\Messenger;

use SoftWax\CorrelationIds\Model\CorrelationIds;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\StampInterface;

final readonly class CorrelationIdsStamp implements StampInterface, \JsonSerializable
{
    public function __construct(
        private string $currentId,
        private ?string $parentId,
        private string $rootId,
    ) {
    }

    public static function new(CorrelationIds $correlationIds): CorrelationIdsStamp
    {
        return new self(
            $correlationIds->getCurrentId(),
            $correlationIds->getParentId(),
            $correlationIds->getRootId(),
        );
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

    /**
     * @return array{'currentId': string, 'parentId': ?string, 'rootId': string}
     */
    public function jsonSerialize(): array
    {
        return [
            'currentId' => $this->currentId,
            'parentId' => $this->parentId,
            'rootId' => $this->rootId,
        ];
    }

    public static function getFromEnvelope(Envelope $envelope): ?CorrelationIdsStamp
    {
        $stamp = $envelope->last(CorrelationIdsStamp::class);

        return $stamp instanceof CorrelationIdsStamp ? $stamp : null;
    }
}

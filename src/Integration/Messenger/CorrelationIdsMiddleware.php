<?php

declare(strict_types=1);

namespace SoftWax\CorrelationIds\Integration\Messenger;

use SoftWax\CorrelationIds\Storage\CorrelationIdsStorage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

final readonly class CorrelationIdsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private CorrelationIdsStorage $storage,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (CorrelationIdsStamp::getFromEnvelope($envelope) === null) {
            $envelope = $envelope->with(
                CorrelationIdsStamp::new($this->storage->get()),
            );
        }

        return $stack->next()->handle($envelope, $stack);
    }
}

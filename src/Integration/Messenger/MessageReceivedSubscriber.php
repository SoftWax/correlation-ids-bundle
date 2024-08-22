<?php

declare(strict_types=1);

namespace SoftWax\CorrelationIds\Integration\Messenger;

use SoftWax\CorrelationIds\Factory\CorrelationIdsFactory;
use SoftWax\CorrelationIds\Storage\CorrelationIdsStorage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;

final readonly class MessageReceivedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private CorrelationIdsStorage $storage,
        private CorrelationIdsFactory $factory,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        if (!\class_exists(WorkerMessageReceivedEvent::class)) {
            return [];
        }

        return [
            WorkerMessageReceivedEvent::class => ['onMessageReceived', 65536],
        ];
    }

    public function onMessageReceived(WorkerMessageReceivedEvent $event): void
    {
        $stamp = CorrelationIdsStamp::getFromEnvelope($event->getEnvelope());
        if ($stamp === null) {
            return;
        }

        $this->storage->get()->replace(
            $this->factory->create(
                parentId: $stamp->getCurrentId(),
                rootId: $stamp->getRootId(),
            ),
        );
    }
}

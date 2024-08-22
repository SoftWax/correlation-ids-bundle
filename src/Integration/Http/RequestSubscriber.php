<?php

declare(strict_types=1);

namespace SoftWax\CorrelationIds\Integration\Http;

use SoftWax\CorrelationIds\Factory\CorrelationIdsFactory;
use SoftWax\CorrelationIds\Storage\CorrelationIdsStorage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class RequestSubscriber implements EventSubscriberInterface
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
        if (!\class_exists(KernelEvents::class)) {
            return [];
        }

        return [
            KernelEvents::REQUEST => ['onKernelRequest', 65536],
        ];
    }

    public function onKernelRequest(KernelEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        // TODO: implement replacing with received header.

        $this->storage->get()->replace(
            $this->factory->create(),
        );
    }
}

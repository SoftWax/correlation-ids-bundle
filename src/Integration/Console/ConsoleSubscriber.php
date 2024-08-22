<?php

declare(strict_types=1);

namespace SoftWax\CorrelationIds\Integration\Console;

use SoftWax\CorrelationIds\Factory\CorrelationIdsFactory;
use SoftWax\CorrelationIds\Generator\IdGeneratorInterface;
use SoftWax\CorrelationIds\Storage\CorrelationIdsStorage;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class ConsoleSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private CorrelationIdsStorage $storage,
        private CorrelationIdsFactory $factory,
        private IdGeneratorInterface $idGenerator,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        if (!\class_exists(ConsoleEvents::class)) {
            return [];
        }

        return [
            ConsoleEvents::COMMAND => ['onConsoleCommand', 65536],
        ];
    }

    public function onConsoleCommand(ConsoleEvent $event): void
    {
        $currentId = $this->idGenerator->generate();

        $commandName = $event->getCommand()?->getName();
        if ($commandName !== null) {
            $currentId = \sprintf('%s|%s', $currentId, $commandName);
        }

        $this->storage->get()->replace(
            $this->factory->create(
                currentId: $currentId,
            ),
        );
    }
}

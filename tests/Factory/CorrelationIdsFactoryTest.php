<?php

declare(strict_types=1);

namespace SoftWaxTests\CorrelationIds\Factory;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SoftWax\CorrelationIds\Factory\CorrelationIdsFactory;
use SoftWax\CorrelationIds\Generator\IdGeneratorInterface;
use SoftWax\CorrelationIds\Model\CorrelationIds;

class CorrelationIdsFactoryTest extends TestCase
{
    private MockObject&IdGeneratorInterface $idGenerator;

    private CorrelationIdsFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->idGenerator = $this->createMock(IdGeneratorInterface::class);
        $this->factory = new CorrelationIdsFactory($this->idGenerator);
    }

    #[DataProvider('dataProvider')]
    public function testCreatesContainer(
        ?string $currentId,
        ?string $parentId,
        ?string $rootId,
        CorrelationIds $expectedOutput,
    ): void {
        if ($currentId === null) {
            $this->idGenerator->expects($this->once())->method('generate')->willReturn('newId');
        } else {
            $this->idGenerator->expects($this->never())->method('generate');
        }

        self::assertEquals(
            $expectedOutput,
            $this->factory->create($currentId, $parentId, $rootId),
        );
    }

    /**
     * @return iterable<array{0: string|null, 1: string|null, 2: string|null, 3: CorrelationIds}>
     */
    public static function dataProvider(): iterable
    {
        yield 'all null values' => [
            null,
            null,
            null,
            new CorrelationIds('newId', null, 'newId'),
        ];

        yield 'with current id' => [
            'oldId',
            null,
            null,
            new CorrelationIds('oldId', null, 'oldId'),
        ];

        yield 'with current id and root' => [
            'oldId',
            null,
            'rootId',
            new CorrelationIds('oldId', null, 'rootId'),
        ];

        yield 'with root id' => [
            null,
            null,
            'rootId',
            new CorrelationIds('newId', null, 'rootId'),
        ];

        yield 'with parent and root id' => [
            null,
            'parentId',
            'rootId',
            new CorrelationIds('newId', 'parentId', 'rootId'),
        ];

        yield 'with all arguments' => [
            'myId',
            'parentId',
            'rootId',
            new CorrelationIds('myId', 'parentId', 'rootId'),
        ];
    }
}

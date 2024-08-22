<?php

declare(strict_types=1);

namespace SoftWaxTests\CorrelationIds\Generator;

use PHPUnit\Framework\TestCase;
use SoftWax\CorrelationIds\Generator\SnowflakeIdGenerator;

class SnowflakeIdGeneratorTest extends TestCase
{
    public function testGeneration(): void
    {
        $generator = new SnowflakeIdGenerator();

        $start = \microtime(true);
        $ids = [];
        for ($i = 0; $i < 10000; $i++) {
            $ids[] = $generator->generate();
        }

        self::assertLessThanOrEqual(0.2, \microtime(true) - $start);
        self::assertCount(10000, \array_unique($ids));
    }
}

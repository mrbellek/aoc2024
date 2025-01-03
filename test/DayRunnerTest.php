<?php 

declare(strict_types=1);

namespace AdventOfCode;

use AdventOfCode\DayRunner;
use PHPUnit\Framework\TestCase;

class DayRunnerTest extends TestCase
{
    public function testConstants(): void
    {
        static::assertClassConstantSame('Year', DayRunner::class, 'YEAR_PREFIX');
        static::assertClassConstantSame('Day', DayRunner::class, 'DAY_PREFIX');
        static::assertClassConstantSame('test', DayRunner::class, 'ENV_TEST');
        static::assertClassConstantSame('live', DayRunner::class, 'ENV_LIVE');
    }

    static private function assertClassConstantSame($expected, string $className, string $contName)
    {
        $const = new \ReflectionClassConstant($className, $contName);

        static::assertSame($expected, $const->getValue());
    }
}

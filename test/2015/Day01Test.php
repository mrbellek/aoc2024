<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\Helpers\InputHelper;
use AdventOfCode\Helpers\Logger;
use AdventOfCode\Year2015\Day01;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class Day01Test extends TestCase
{
    private InputHelper&MockObject $inputHelper;
    private Logger&MockObject $logger;

    public function setUp(): void
    {
        $this->inputHelper = $this->createMock(InputHelper::class);
        $this->logger = $this->createMock(Logger::class);
    }

    #[DataProvider('part1DataProvider')]
    public function testPart1($expected, string $input): void
    {
        $this->inputHelper
            ->expects($this->exactly(2))
            ->method('getInput')
            ->willReturnOnConsecutiveCalls([$input], $input);

        $class = new Day01($this->inputHelper, $this->logger, 'test');

        $this->logger
            ->expects($this->once())
            ->method('log')
            ->with($expected);

        $class->part1();
    }

    #[DataProvider('part2DataProvider')]
    public function testPart2($expected, string $input): void
    {
        $this->inputHelper
            ->expects($this->exactly(2))
            ->method('getInput')
            ->willReturnOnConsecutiveCalls([$input], $input);

        $class = new Day01($this->inputHelper, $this->logger, 'test');

        $this->logger
            ->expects($this->once())
            ->method('log')
            ->with($expected);

        $class->part2();
    }

    static public function part1DataProvider(): array
    {
        return [
            ['Input ( puts Santa on floor 1.', '('],
            ['Input ((( puts Santa on floor 3.', '((('],
            ['Input ) puts Santa on floor -1.', ')'],
            ['Input ))) puts Santa on floor -3.', ')))'],

            ['Input () puts Santa on floor 0.', '()'],
            ['Input ()) puts Santa on floor -1.', '())'],
            ['Input )( puts Santa on floor 0.', ')('],
            ['Input )(( puts Santa on floor 1.', ')(('],
        ];
    }

    static public function part2DataProvider(): array
    {
        return [
            ['Final floor is 1, but Santa did not go into the basement', '('],
            ['Final floor is 0, and Santa went into the basement first at instruct 1', ')('],
            ['Final floor is -1, and Santa went into the basement first at instruct 3', '())(())'],
        ];
    }
}

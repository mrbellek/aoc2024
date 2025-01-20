<?php

namespace AdventOfCode\Year2015;

use AdventOfCode\Helpers\InputHelper;
use AdventOfCode\Helpers\Logger;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

#[CoversClass(Day12::class)]
class Day12Test extends TestCase
{
    private InputHelper&MockObject $inputHelper;
    private Logger&MockObject $logger;

    protected function setUp(): void
    {
        $this->inputHelper = $this->createMock(InputHelper::class);
        $this->logger = $this->createMock(Logger::class);
    }

    #[DataProvider('part1DataProvider')]
    public function testPart1(string $expected, string $input): void
    {
        $this->inputHelper
            ->expects($this->exactly(2))
            ->method('getInput')
            ->willReturnOnConsecutiveCalls([$input], $input);

        $this->logger
            ->method('log')
            ->with($expected);

        $object = new Day12($this->inputHelper, $this->logger, 'test');
        $object->part1();
    }

    public static function part1DataProvider(): array
    {
        return [
            'sample json data' => ['Sum of all numbers is 6', '[1,{"c":"red","b":2},3]'],
        ];
    }

    #[DataProvider('part2DataProvider')]
    public function testPart2($expected, string $input): void
    {
        $this->inputHelper
            ->expects($this->exactly(2))
            ->method('getInput')
            ->willReturnOnConsecutiveCalls([$input], $input);

        $this->logger
            ->expects($this->once())
            ->method('log')
            ->with($expected);

        $object = new Day12($this->inputHelper, $this->logger, 'test');
        $object->part2();
    }

    public static function part2DataProvider(): array
    {
        return [
            'sample json data' => ['Sum of non-red numbers is 4', '[1,{"c":"red","b":2},3]'],
            'piece of live data' => ['Sum of non-red numbers is ?', '{"e":[[{"e":86,"c":23,"a":{"a":[120,169,"green","red","orange"]}}]]}'],
        ];
    }
}

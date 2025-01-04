<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\Helpers\InputHelper;
use AdventOfCode\Helpers\Logger;
use AdventOfCode\Year2015\Day08;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class Day08Test extends TestCase
{
    private InputHelper&MockObject $inputHelper;
    private Logger&MockObject $logger;

    protected function setUp(): void
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

        $this->logger
            ->expects($this->once())
            ->method('log')
            ->with($expected);

        $object = new Day08($this->inputHelper, $this->logger, 'test');
        $object->part1();
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

        $object = new Day08($this->inputHelper, $this->logger, 'test');
        $object->part2();
    }

    static public function part1DataProvider(): array
    {
        return [
            'Bookend quotes' => ['Total difference: 2', '"aaa"'],
            'Bookend quotes and escaped quote' => ['Total difference: 3', '"aa\"aa"'],
            'Bookend quotes and escaped bslash' => ['Total difference: 3', '"aa\\\\aa"'],
            'Bookend quotes and 2 escaped bslash' => ['Total difference: 4', '"aa\\\\\\\\aa"'],
            'Bookend quotes, escaped bslash and loose bslash' => ['Total difference: 3', '"aa\\\\\aa"'],
            'Bookend quotes, escaped quote and loose quote' => ['Total difference: 3', '"aa\""aa"'],
            'Escaped character' => ['Total difference: 5', '"aa\x3a"'],
            'Invalid escaped character' => ['Total difference: 2', '"aa\xzza"'],
        ];
    }

    static public function part2DataProvider(): array
    {
        return [

        ];
    }
}

<?php

declare(strict_types=1);

namespace AdventOfCode;

use AdventOfCode\AbstractDay;
use AdventOfCode\Helpers\InputHelper;
use AdventOfCode\Helpers\Logger;
use AdventOfCode\Traits\ReflectionTesterTrait;
use AdventOfCode\Year2015\Day01;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PHPUnit\Metadata\CoversClass;

#[CoversClass(AbstractDay::class)]
class AbstractDayTest extends TestCase
{
    use ReflectionTesterTrait;

    private InputHelper&MockObject $inputHelper;
    private Logger&MockObject $logger;

    function setUp(): void
    {
        $this->inputHelper = $this->createMock(InputHelper::class);
        $this->logger = $this->createMock(Logger::class);
    }

    public function testConstruct(): void
    {
        $this->inputHelper
            ->expects($this->exactly(2))
            ->method('getInput')
            ->willReturnOnConsecutiveCalls(['test input'], 'test input');

        $object = new Day01(
            $this->inputHelper,
            $this->logger,
            'test'
        );

        static::assertClassVarSame(['test input'], $object, 'input');
        static::assertClassVarSame('test input', $object, 'inputStr');
    }
}
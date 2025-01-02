<?php

declare(strict_types=1);

namespace AdventOfCode;

use AdventOfCode\AbstractDay;
use PHPUnit\Framework\TestCase;

class AbstractDayTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->object = $this->createMock(AbstractDay::class);
        $this->object = $this->getMockBuilder(AbstractDay::class)
            ->setMockClassName('Day01')
            ->setConstructorArgs(['test'])
            ->getMock();

        die(var_dump(get_class($this->object)));
    }
}
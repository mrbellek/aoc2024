<?php 

declare(strict_types=1);

namespace AdventOfCode;

use AdventOfCode\DayRunner;
use AdventOfCode\Helpers\GlobHelper;
use AdventOfCode\Helpers\Logger;
use AdventOfCode\Traits\ReflectionTesterTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DayRunnerTest extends TestCase
{
    use ReflectionTesterTrait;

    private GlobHelper&MockObject $globHelper;
    private Logger&MockObject $logger;

    protected function setUp(): void
    {
        $this->globHelper = $this->createMock(GlobHelper::class);
        $this->logger = $this->createMock(Logger::class);
    }

    public function testWithArgumentInvalidYear(): void
    {
        $argv = [
            'runday.php',
            '2002',
        ];

        $this->logger
            ->expects($this->exactly(2))
            ->method('fatal')
            //->with('FATAL: Cannot find class file for Year2002/Day01!')
            //@TODO figure out an alternative to withConsecutive in PHPUnit 10
        ;

        $object = new DayRunner($this->globHelper, $this->logger, $argv);
    }

    public function testNoArguments(): void
    {

    }

    public function testConstants(): void
    {
        static::assertClassConstantSame('Year', DayRunner::class, 'YEAR_PREFIX');
        static::assertClassConstantSame('Day', DayRunner::class, 'DAY_PREFIX');
        static::assertClassConstantSame('test', DayRunner::class, 'ENV_TEST');
        static::assertClassConstantSame('live', DayRunner::class, 'ENV_LIVE');
    }
}

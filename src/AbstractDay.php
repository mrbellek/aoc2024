<?php

declare(strict_types=1);

namespace AdventOfCode;

use AdventOfCode\DayRunner;
use AdventOfCode\Helpers\InputHelper;
use AdventOfCode\Helpers\Logger;

abstract class AbstractDay
{
    protected array $input;
    protected string $inputStr;
    protected bool $isLive;

    public const PART1_COMPLETE = false;
    public const PART2_COMPLETE = false;

    public function __construct(
        InputHelper $inputHelper,
        private readonly Logger $logger,
        string $dataSet
    ) {
        $this->isLive = $dataSet === DayRunner::ENV_LIVE;
        $this->input = $inputHelper->getInput($this, $dataSet, false);
        $this->inputStr = $inputHelper->getInput($this, $dataSet, true);
    }

    public function part1(): void
    {
        die('Part1 is unfinished for this day!');
    }

    public function part2(): void
    {
        die('Part2 is unfinished for this day!');
    }

    protected function debug(string $s): void
    {
        if ($this->isLive === false) {
            $this->logger->debug($s);
        }
    }

    protected function log(string $s): void
    {
        $this->logger->log($s);
    }

    protected function fatal(string $s): void
    {
        $this->logger->fatal($s);
        exit(1);
    }

    protected function dd(mixed $input1, mixed $input2 = null): never
    {
        var_dump($input1, $input2);
        exit(1);
    }
}
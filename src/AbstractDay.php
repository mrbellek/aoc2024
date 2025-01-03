<?php

declare(strict_types=1);

namespace AdventOfCode;

use AdventOfCode\Helpers\InputHelper;
use AdventOfCode\Traits\LoggerTrait;

abstract class AbstractDay
{
    use LoggerTrait;

    protected array $input;
    protected string $inputStr;
    protected bool $isLive;

    public const PART1_COMPLETE = false;
    public const PART2_COMPLETE = false;

    public function __construct(
        InputHelper $inputHelper,
        string $dataSet
    ) {
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
}
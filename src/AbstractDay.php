<?php

declare(strict_types=1);

namespace AdventOfCode;

abstract class AbstractDay
{
    use LoggerTrait;

    protected array $input;
    protected string $inputStr;
    protected bool $isLive;

    public const PART1_COMPLETE = false;
    public const PART2_COMPLETE = false;

    public function __construct(string $dataSet)
    {
        /**
         * TODO
         * - fetch class 
         * - fetch year
         * - fetch input data + sample data
         */

        $className = get_class($this);
        $year = (int) date('Y');
        $day = 1;
        $matches = [];
        if (preg_match('/Year(\d+)\\\Day(\d+)/', $className, $matches) === 1) {
            $year = $matches[1];
            $day = $matches[2];
        }

        switch ($dataSet) {
            case 'test':
                $this->isLive = false;
                $sampleFile = sprintf('./data/%1$d/sample%2$02d.txt', $year, $day);
                if (!is_readable($sampleFile)) {
                    $this->fatal(sprintf('FATAL: Cannot find input file %s!', $sampleFile));
                }
                $this->input = file($sampleFile, FILE_IGNORE_NEW_LINES);
                $this->inputStr = file_get_contents($sampleFile);
                break;
            case 'live':
                $this->isLive = true;
                $inputFile = sprintf('./data/%1$d/input%2$02d.txt', $year, $day);
                if (!is_readable($inputFile)) {
                    $this->fatal(sprintf('FATAL: Cannot find input file %s!', $inputFile));
                }
                $this->input = file($inputFile, FILE_IGNORE_NEW_LINES);
                $this->inputStr = file_get_contents($inputFile);
                break;
            default:
                $this->fatal(sprintf('Invalid environment "%s"', $dataSet));
        }
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

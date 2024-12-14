<?php

declare(strict_types=1);

namespace AdventOfCode;

abstract class AbstractDay
{
    protected array $input;
    protected bool $isLive;

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
                    $this->log(sprintf('FATAL: Cannot find input file %s!', $sampleFile));
                    exit(1);
                }
                $this->input = file($sampleFile, FILE_IGNORE_NEW_LINES);
                break;
            case 'live':
                $this->isLive = true;
                $inputFile = sprintf('./data/%1$d/input%2$02d.txt', $year, $day);
                if (!is_readable($inputFile)) {
                    $this->log(sprintf('FATAL: Cannot find input file %s!', $inputFile));
                    exit(1);
                }
                $this->input = file($inputFile, FILE_IGNORE_NEW_LINES);
                break;
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

    protected function log(string $s): void
    {
        print($s . PHP_EOL);
    }

    protected function debug(string $s): void
    {
        if ($this->isLive === false) {
            print($s . PHP_EOL);
        }
    }
}

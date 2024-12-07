<?php

declare(strict_types=1);

namespace AdventOfCode;

abstract class AbstractDay
{
    protected array $input;

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
                $this->input = file(sprintf('./data/%1$d/sample%2$02d.txt', $year, $day), FILE_IGNORE_NEW_LINES);
                break;
            case 'live':
                $this->input = file(sprintf('./data/%1$d/input%2$02d.txt', $year, $day), FILE_IGNORE_NEW_LINES);
                break;
        }
    }

    abstract function part1(): void;
    abstract function part2(): void;
}

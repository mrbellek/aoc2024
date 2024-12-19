<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

use function str_starts_with;

class Day03 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    public function part1(): void
    {
        $sum = 0;
        foreach ($this->input as $line) {
            $m = [];
            if (preg_match_all('/mul\((\d{1,3}),(\d{1,3})\)/', $line, $m) !== false) {
                for ($i = 0; $i < count($m[0]); $i++) {
                    $sum += $m[1][$i] * $m[2][$i];
                }
            }
        }

        $this->log(sprintf('The total is %d', $sum));
    }

    public function part2(): void
    {
        $sum = 0;
        $enabled = true;
        foreach ($this->input as $line) {
            $m = [];
            if (preg_match_all('/(mul\(\d{1,3},\d{1,3}\))|(don\'t\(\))|(do\(\))/', $line, $m) !== false) {
                for ($i = 0; $i < count($m[0]); $i++) {
                    $match = $m[0][$i];
                    if (str_starts_with($match, 'mul')) {
                        $sum = $enabled ? $sum + $this->getSum($match) : $sum;
                    } elseif (str_starts_with($match, 'don\'t')) {
                        $enabled = false;
                    } elseif (str_starts_with($match, 'do')) {
                        $enabled = true;
                    } else {
                        die('wtf?');
                    }
                }
            }
        }

        $this->log(sprintf('The total with operators is: %d', $sum));
    }

    private function getSum(string $match): int
    {
        if (preg_match('/(\d{1,3}),(\d{1,3})/', $match, $m) !== false) {
            return intval($m[1]) * intval($m[2]);
        }

        die('wtf?');
    }
}

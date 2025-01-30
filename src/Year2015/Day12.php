<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day12 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = false;

    public function part1(): void
    {
        if (preg_match_all('/([-0-9])+/', $this->input[0], $m)) {
            $this->log(sprintf('Sum of all numbers is %d', array_sum($m[0])));
        }
    }

    public function part2(): void
    {
        $sum = $this->recursiveSum(json_decode($this->input[0], false, 512, JSON_THROW_ON_ERROR));
        $this->log(sprintf('Sum of non-red numbers is %d', $sum));
    }

    private function recursiveSum(object $input): int
    {
        $sum = 0;
        foreach (get_object_vars($input) as $prop) {
            if (is_object($prop)) {
                if ($this->isRed($prop) === false) {
                    $sum += $this->recursiveSum($prop);
                }
            } elseif (is_array($prop)) {
                $sum += $this->recursiveSumArray($prop);
            } elseif (is_numeric($prop)) {
                $sum += (int) $prop;
            }
        }

        return $sum;
    }

    private function recursiveSumArray(array $input): int
    {
        $sum = 0;
        foreach ($input as $el) {
            if (is_object($el)) {
                $sum += $this->recursiveSum($el);
            } elseif (is_array($el)) {
                $sum += $this->recursiveSumArray($el);
            } elseif (is_numeric($el)) {
                $sum += (int) $el;
            }
        }

        return $sum;
    }

    private function isRed(object $input): bool
    {
        //print_r($input);
        return in_array('red', get_object_vars($input), true);
    }
}

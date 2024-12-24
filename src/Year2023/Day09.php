<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023;

use AdventOfCode\AbstractDay;

class Day09 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    public function part1(): void
    {
        $totalNextNumbers = 0;
        $totalPreviousNumbers = 0;
        foreach ($input as $line) {
            $numbers = explode(' ', $line);
            [$nextNumber, $previousNumber] = $this->findNextAndPreviousNumber($numbers);
            $this->debug(sprintf('Next line in number sequence "%s" is: %s', $line, $nextNumber));
            $this->debug(sprintf('...and the previous number is: %s', $previousNumber));
            $totalNextNumbers += $nextNumber;
            $totalPreviousNumbers += $previousNumber;
        }
        $this->log(sprintf('Total difference for next numbers: %s', $totalNextNumbers));
        $this->log(sprintf('Total different for previous numbers: %s', $totalPreviousNumbers));
    }
    
    public function part2(): void
    {
        //see part1
    }


    private function findNextAndPreviousNumber(array $numbers): array
    {
        $numbersList = [];
        while ($this->areAllSameNumbers($numbers) === false) {
            $numbersList[] = $numbers;
            $numbers = findDifferences($numbers);
        }
    
        $nextNumber = $numbers[0];
        $previousNumber = $numbers[0];
        foreach (array_reverse($numbersList) as $list) {
            $nextNumber = end($list) + $nextNumber;
            $previousNumber = reset($list) - $previousNumber;
        }
    
        return [$nextNumber, $previousNumber];
    }
    
    private function findDifferences(array $numbers): array
    {
        $newNumbers = [];
        for ($i = 1; $i < count($numbers); $i++) {
            $newNumbers[] = $numbers[$i] - $numbers[$i - 1];
        }
    
        return $newNumbers;
    }
    
    private function areAllSameNumbers(array $numbers): bool
    {
        return implode('', $numbers) === str_repeat((string)$numbers[0], count($numbers));
    }
}

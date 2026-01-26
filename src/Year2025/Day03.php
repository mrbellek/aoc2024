<?php

declare(strict_types=1);

namespace AdventOfCode\Year2025;

use AdventOfCode\AbstractDay;

class Day03 extends AbstractDay
{
    public const PART1_COMPLETE = false;
    public const PART2_COMPLETE = false;

    public function part1(): void
    {
        $totalJoltage = 0;
        foreach ($this->input as $bank) {
            $totalJoltage += $this->getMaxJoltage($bank);
        }

        $this->log(sprintf('The total output joltage is %d', $totalJoltage));
    }

    public function part2(): void
    {
        $totalSuperJoltage = 0;
        foreach ($this->input as $bank) {
            $totalSuperJoltage += $this->getMaxSuperJoltage($bank);
        }

        $this->log(sprintf('The total output super joltage is %d', $totalSuperJoltage));
    }

    private function getMaxJoltage(string $bank): int
    {
        $max = '00';
        $arr = str_split($bank);
        $arrCount = count($arr);
        foreach ($arr as $i => $num1) {
            for ($j = $i + 1 ; $j < $arrCount; $j++) {
                $num2 = $arr[$j];
                if ((int) ($num1 . $num2) > (int)$max) {
                    $max = $num1 . $num2;
                }
            }
        }
        $this->debug(sprintf('Max values in %s was: %s', $bank, $max));

        return (int)$max;
    }

    //we need to find the highest number in the bank, in a location that can still
    //have 11 numbers after it to form the 12 batteries to turn on with the highest joltage
    private function getMaxSuperJoltage(string $bank): float
    {
        $this->log($bank);
        $trimmedBank = substr($bank, 0, -11);
        $maxSuperJoltage = '';
        do {
            $highestNumber = max(str_split($trimmedBank));
            $lastPos = strrpos($trimmedBank, $highestNumber);
            $maxSuperJoltage .= $highestNumber;
            //now loop through all subsequent numbers to find highest combination?
            $this->dd($lastPos, 2, 3, 4);

        } while (strlen($maxSuperJoltage) < 12);
    }
}
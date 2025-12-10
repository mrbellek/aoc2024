<?php

declare(strict_types=1);

namespace AdventOfCode\Year2025;

use AdventOfCode\AbstractDay;

class Day03 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = false;

    public function part1(): void
    {
        $totalJoltage = 0;
        foreach ($this->input as $bank) {
            $totalJoltage += $this->getMaxJoltage($bank);
        }

        $this->log(sprintf('The total output joltage is %d', $totalJoltage));
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
}
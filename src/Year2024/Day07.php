<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day07 extends AbstractDay
{
    private const ALLOWED_OPERATORS = ['*', '+'];

    public function part1(): void
    {
        $totalPossibleSums = 0;
        foreach ($this->input as $i => $line) {
            [$expectedSum, $numbers] = explode(': ', $line);
            if ($this->canNumbersMakeSum(explode(' ', $numbers), (float) $expectedSum, 2)) {
                $totalPossibleSums += $expectedSum;
            }
        }

        printf('The total of all sums that can be made is %d' . PHP_EOL, $totalPossibleSums);
    }

    public function part2(): void
    {
        $totalPossibleSums = 0;
        foreach ($this->input as $i => $line) {
            [$expectedSum, $numbers] = explode(': ', $line);
            if ($this->canNumbersMakeSum(explode(' ', $numbers), (float) $expectedSum, 3)) {
                $totalPossibleSums += $expectedSum;
            }
        }

        printf('The total of all sums that can be made with 3 operators is %d' . PHP_EOL, $totalPossibleSums);
    }

    private function canNumbersMakeSum(array $numbers, float $expectedTotal, int $base): bool
    {
        $opSpaces = count($numbers) - 1;
        $numPermutations = pow($base, $opSpaces);
        $actualTotal = 0;
        for ($i = 0; $i < $numPermutations; $i++) {
            $actualTotal = intval($numbers[0]);
            $formula = $numbers[0];
            $bitstring = str_pad(base_convert((string)$i, 10, $base), $opSpaces, '0', STR_PAD_LEFT);
            for ($j = 0; $j < $opSpaces; $j++) {
                switch (substr($bitstring, $j, 1)) {
                    case '0':
                        $actualTotal *= intval($numbers[$j+1]);
                        $formula .= '*' . $numbers[$j+1];
                        break;
                    case '1':
                        $actualTotal += intval($numbers[$j+1]);
                        $formula .= '+' . $numbers[$j+1];
                        break;
                    case '2':
                        $actualTotal = $actualTotal . $numbers[$j+1];
                        $formula .= '||' . $numbers[$j+1];
                        break;
                }
            }

            if ($actualTotal == $expectedTotal) {
                echo $formula . ' = ' . $actualTotal . PHP_EOL;
                return true;
            }
        }

        return false;
    }
}

<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023;

use AdventOfCode\AbstractDay;

class Day01 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;
    
    public function part2(): void
    {
        $sumOfNumbers = 0;
        foreach ($this->input as $line) {
            $this->debug(sprintf('turned %s into ', $line));
            $line = $this->replaceNumberWordsWithDigits($line);
            $this->debug(sprintf('%s', $line));
            $digits = $this->getFirstAndLastDigitsFromLine($line);
            $number = intval($digits[0] . $digits[1]);
            $sumOfNumbers += $number;
        }

        $this->log(sprintf('The total sum of all numbers is: %s', $sumOfNumbers));
    }

    private function getFirstAndLastDigitsFromLine(string $line): array
    {
        $justDigits = preg_replace('/[^0-9]/', '', $line);
        if (strlen($justDigits) < 1) {
            $this->fatal(sprintf('er is niets over van regel %s', $line));
        }
        
        return [
            substr($justDigits, 0, 1),
            substr($justDigits, -1),
        ];
    }
    
    private function replaceNumberWordsWithDigits(string $line): string
    {
        //this is just plain evil :(
        $line = str_replace(
            ['oneight', 'threeight', 'fiveight', 'nineight', 'twone', 'threeight', 'fiveight', 'sevenine', 'eightwo', 'eighthree', ],
            ['18', '38', '58', '98', '21', '38', '58', '79', '82', '83', ],
            $line
        );
        
        $line = str_replace(
            ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'],
            ['1', '2', '3', '4', '5', '6', '7', '8', '9'],
            $line
        );
        
        return $line;
    }
}

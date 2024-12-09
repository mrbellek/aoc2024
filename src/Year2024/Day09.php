<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day09 extends AbstractDay
{
    public function part1(): void
    {
        $blockString = $this->convertMapToBlockString($this->input[0]);

        for ($i = 0; $i < strlen($blockString); $i++) {
            print($blockString) . PHP_EOL;
            $rightCharPos = $this->findRightMostChar($blockString);
            $rightChar = substr($blockString, $rightCharPos, 1);
            $firstDot = strpos($blockString, '.');
            
            $blockString[$firstDot] = $rightChar;
            $blockString[$rightCharPos] = '.';
            
            if (preg_match('/^[A-Za-z0-9]+\.+$/', $blockString) === 1) {
                break;
            }
        }
        print($blockString);

        $checksum = 0;
        for ($i = 0; $i < strlen($blockString); $i++) {
            $checksum += intval($i) * intval($blockString[$i]);
        }

        printf(PHP_EOL . 'The checksum is %d' . PHP_EOL, $checksum);
    }

    public function part2(): void
    {

    }

    private function convertMapToBlockString(string $map): string
    {
        $blockString = '';
        $mapArray = str_split($map);
        $files = array_values(array_filter($mapArray, fn (int $index) => $index % 2 === 0, ARRAY_FILTER_USE_KEY));
        $spaces = array_values(array_filter($mapArray, fn (int $index) => $index % 2 === 1, ARRAY_FILTER_USE_KEY));
      
        for ($i = 0; $i < max(count($files), count($spaces)); $i++) {
            $blockString .= str_repeat((string) $i, (int) $files[$i] ?? 0);
            $blockString .= str_repeat('.', (int) $spaces[$i] ?? 0);
            
        }
        
        return $blockString;
    }

    private function findRightMostChar(string $blockString): int
    {
        $m = [];
        if (preg_match('/[A-Za-z0-9]/', strrev($blockString), $m, PREG_OFFSET_CAPTURE) === 1) {
            return strlen($blockString) - $m[0][1] - 1;
        }
        
        throw new RuntimeException('wtf');
    }
}
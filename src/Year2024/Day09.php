<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day09 extends AbstractDay
{
    public function part1(): void
    {
        $this->log('Converting input to block string..');
        $blockString = $this->convertMapToBlockString($this->input[0]);

        $this->log('Defragmenting..');
        for ($i = 0; $i < strlen($blockString); $i++) {
            if ($this->isLive) {
                if ($i % 1000 === 0) {
                    echo '.';
                }
            } else {
                $this->debug($blockString);
            }
            $rightCharPos = $this->findRightMostChar($blockString);
            $rightChar = substr($blockString, $rightCharPos, 1);
            $firstDot = strpos($blockString, '.');
            
            $blockString[$firstDot] = $rightChar;
            $blockString[$rightCharPos] = '.';
            
            if (preg_match('/^[A-Za-z0-9]+\.+$/', $blockString) === 1) {
                break;
            }
        }

        $this->debug($blockString);
        $this->log(PHP_EOL . 'Done!');

        $checksum = 0.0;
        for ($i = 0; $i < strlen($blockString); $i++) {
            $checksum += (float) ((float) $i * (float) $blockString[$i]);
        }

        $this->log(sprintf('The checksum is %s', $checksum));
    }

    public function part2(): void
    {
        die('unfinished!');
    }

    private function convertMapToBlockString(string $map): string
    {
        $blockString = '';
        $mapArray = str_split($map);
        $files = array_values(array_filter($mapArray, fn (int $index) => $index % 2 === 0, ARRAY_FILTER_USE_KEY));
        $spaces = array_values(array_filter($mapArray, fn (int $index) => $index % 2 === 1, ARRAY_FILTER_USE_KEY));
      
        for ($i = 0; $i < max(count($files), count($spaces)); $i++) {
            $blockString .= str_repeat((string) $i, (int) $files[$i] ?? 0);
            $blockString .= str_repeat('.', (int) ($spaces[$i] ?? 0));
        }
        $this->log(sprintf('Converted input of %d bytes into blockstring of length %d', strlen($map), strlen($blockString)));
        
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
<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day08 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    public function part1(): void
    {
        $sum = 0;
        foreach ($this->input as $line) {
            $line = trim($line);

            $length = strlen($line);
            $newLine = $this->replaceLiterals($line);
            $actualLength = strlen($newLine);

            $this->debug(sprintf(
                'String %s is %d characters in code, but %d characters in memory, difference %d',
                $line,
                $length,
                $actualLength,
                $length - $actualLength
            ));

            $sum += $length - $actualLength;
        }

        $this->log(sprintf('Total difference: %d', $sum));
    }

    public function part2(): void
    {
        $sum = 0;
        foreach ($this->input as $line) {
            $line = trim($line);

            $length = strlen($line);
            $newLine = $this->encodeString($line);
            $encodedLength = strlen($newLine);

            $this->debug(sprintf(
                'String %s is %d characters long, but %d characters when encoded (%s), difference %d',
                $line,
                $length,
                $encodedLength,
                $newLine,
                $encodedLength - $length
            ));

            $sum += $encodedLength - $length;
        }
        
        $this->log(sprintf('Total difference: %d', $sum));
    }

    private function replaceLiterals(string $line): string
    {
        return
            //replace escaped quotes
            str_replace('\\"', '"',

            //replace escaped backslashes
            str_replace('\\\\', '\\', 

            //replace escaped characters
            preg_replace('/\\\x[0-9a-f]{2}/', 'x',

            //remove bookend quotes
            substr($line, 1, -1)
        )));
    }

    private function encodeString(string $line): string
    {
        return '"' . 
            str_replace(['\\', '"'], ['\\\\', '\"'],
            $line
        ) . '"';
    }
}

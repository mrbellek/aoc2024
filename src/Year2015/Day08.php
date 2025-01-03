<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day08 extends AbstractDay
{
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

    private function replaceLiterals(string $line): string
    {
        $newline = preg_replace('/\\\x[0-9a-f]{2}/', 'x', $line);
        $newline = str_replace('\\"', '"', $newline);
        $newline = str_replace('\\\\', '\\', $newline);

        return trim($newline, '"');
//        return trim(str_replace('\\', '', $newline), '"');
    }
}

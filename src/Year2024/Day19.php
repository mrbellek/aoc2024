<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day19 extends AbstractDay
{
    private array $patterns;

    public function part1(): void
    {
        $this->getPatterns();
        $designs = array_slice($this->input, 2);
        $patternStr = '';
        $possibleCount = 0;
        foreach ($designs as $index => $design) {
            $pos = 0;
            $impossible = false;
            while ($pos < strlen($design)) {
                $lastPos = $pos;
                //the problem here is that once a partial solution is wrong, any
                //of the used parts might have a shorter part that is correct.
                //recursion is probably the solution here?
                foreach ($this->patterns as $pattern) {
                    if (strpos($design, $pattern, $pos) === $pos) {
                        $pos += strlen($pattern);
                        $patternStr .= '+' . $pattern;
                    }
                }
                if ($lastPos === $pos) {
                    $impossible = true;
                    $this->log(sprintf('[%d] %s: STOPPED %s', $index, $design, ltrim($patternStr, '+')));
                    break;
                }
            }
            if ($impossible) {
//                $this->log(sprintf('[%d] %s cannot be made!', $index, $design));
            } else {
//                $this->log(sprintf('[%d] %s: %s', $index, $design, ltrim($patternStr, '+')));
                $possibleCount++;
            }
            $patternStr = '';
        }

        $this->log(sprintf('Out of %d total designs, %d are possible to make with given patterns.', count($designs), $possibleCount));
    }

    private function getPatterns(): void
    {
        $this->patterns = explode(', ', $this->input[0]);
        usort($this->patterns, static fn($a, $b) => strlen($b) <=> strlen($a));
        $this->debug(sprintf('Available patterns: %d', count($this->patterns)));
    }
}

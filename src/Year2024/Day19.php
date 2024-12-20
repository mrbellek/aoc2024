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
                foreach ($this->patterns as $pattern) {
                    if (strpos($design, $pattern, $pos) === $pos) {
                        $pos += strlen($pattern);
                        $patternStr .= '+' . $pattern;
                    }
                }
                if ($lastPos === $pos) {
                    $impossible = true;
                    break;
                }
            }
            if ($impossible) {
                $this->log(sprintf('Design %d %s cannot be made!', $index, $design));
            } else {
                $this->debug(sprintf('Design %d %s can be made with pattern sequence %s!', $index, $design, ltrim($patternStr, '+')));
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

<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day05 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    public function part1(): void
    {
        $nice = 0;
        foreach ($this->input as $string) {
            if ($this->isNice($string)) {
                $nice++;
                $this->debug(sprintf('NICE: %s', $string));
            }
        }

        $this->log(sprintf('Out of %d total, %d strings were NICE.', count($this->input), $nice));
    }

    public function part2(): void
    {
        if (!$this->isLive) {
            $this->input = file('data/2015/sample05-2.txt', FILE_IGNORE_NEW_LINES);
        }

        $nice = 0;
        foreach ($this->input as $string) {
            if ($this->isNiceToo($string)) {
                $nice++;
                $this->debug(sprintf('NICE: %s', $string));
            }
        }

        $this->log(sprintf('%d strings are NICE too', $nice));
    }

    private function isNice(string $string): bool
    {
        //must not contain a banned string
        if (preg_match('/ab|cd|pq|xy/', $string) === 1) {
            $this->log(sprintf('NAUGHTY: %s (because banned string)', $string));
            return false;
        }
        
        //must contain at least three vowels
        if (preg_match_all('/[aeuio]/', $string) < 3) {
            $this->log(sprintf('NAUGHTY: %s (because no 3 vowels)', $string));
            return false;
        }

        //must contain at least one letter that appears twice in a row
        if (preg_match('/(\w)\1/', $string) !== 1) {
            $this->log(sprintf('NAUGHTY: %s (because no double char)', $string));
            return false;
        }

        return true;
    }

    private function isNiceToo(string $string): bool
    {
        //contains a pair of any two letters that appears at least twice
        //in the string without overlapping
        if (preg_match('/(\w{2}).*\1/', $string) !== 1) {
            return false;
        }

        //contains at least one letter which repeats with exactly one
        //letter between them
        if (preg_match('/(\w)\w\1/', $string) !== 1) {
            return false;
        }

        return true;
    }
}

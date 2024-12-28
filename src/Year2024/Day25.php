<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day25 extends AbstractDay
{
    public const PART1_COMPLETE = true;

    private string $ln;

    public function part1(): void
    {
        //not sure why but for some stupid reason the day 25 input file
        //uses different line endings than usual
        if ($this->isLive) {
            $this->ln = "\n";
        } else {
            $this->ln = PHP_EOL;
        }
        $keysAndLocks = explode($this->ln . $this->ln, $this->inputStr);
        [$keys, $locks] = $this->processKeysAndLocks($keysAndLocks);
        $this->log(sprintf('Parsed data into %d locks and %d keys', count($locks), count($keys)));

        $keyAndLocksFit = [];
        foreach ($locks as $lock) {
            foreach ($keys as $key) {
                if (max($this->arrayAdd($lock, $key)) <= 5) {
                    $keyAndLocksFit[] = [$key, $lock];
                }
            }
        }

        $this->log(sprintf('Found %d key+lock combos that dont overlap.', count($keyAndLocksFit)));
    }

    private function arrayAdd(array $lock, array $key): array
    {
        $sum = [];
        for ($i = 0; $i < 5; $i++) {
            $sum[] = $lock[$i] + $key[$i];
        }

        return $sum;
    }
    
    private function processKeysAndLocks(array $keysAndLocks): array
    {
        $keys = [];
        $locks = [];
        foreach ($keysAndLocks as $keyOrLockRaw) {
            $keyOrLock = explode($this->ln, $keyOrLockRaw);
            if ($keyOrLock[0] === '#####') {
                $keys[] = $this->parseKey($keyOrLock);
            } else {
                $locks[] = $this->parseLock($keyOrLock);
            }
        }

        return [$keys, $locks];
    }

    private function parseKey(array $key): array
    {
        //key: top row is #####
        foreach ($key as $i => $line) {
            $key[$i] = str_split($line);
        }

        $keyNumbers = [];
        for ($i = 0; $i < count($key[0]); $i++) {
            $keyNumbers[] = substr_count(implode('', array_column($key, $i)), '#') - 1;
        }

        return $keyNumbers;
    }

    private function parseLock(array $lock): array
    {
        //lock: bottom row is #####
        foreach ($lock as $i => $line) {
            $lock[$i] = str_split($line);
        }

        $lockNumbers = [];
        for ($i = 0; $i < count($lock[0]); $i++) {
            $lockNumbers[] = substr_count(implode('', array_column($lock, $i)), '#') - 1;
        }

        return $lockNumbers;
    }
}

<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day11 extends AbstractDay
{
    private array $cache;

    public function part1(): void
    {
        $stones = explode(' ', $this->input[0]);
        $totalCount = 0;
        foreach ($stones as $stone) {
            $totalCount += $this->blink((int) $stone, 25);
        }

        $this->log(sprintf('Total stone count is %1$.0f after 25 blinks', $totalCount));
    }

    public function part2(): void
    {
        $stones = explode(' ', $this->input[0]);
        $totalCount = 0;
        foreach ($stones as $stone) {
            $totalCount += $this->blink((int) $stone, 75);
        }

        $this->log(sprintf('Total stone count is %1$.0f after 75 blinks', $totalCount));
    }

    private function blink(int $stone, int $iter): float
    {
        $cacheKey = sprintf('%d,%d', $stone, $iter);
        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        if ($iter === 0) {
            $count = 1;
        } elseif ($stone === 0) {
            $count = $this->blink(1, $iter - 1);
        } elseif (strlen((string)$stone) % 2 === 0) {
            [$left, $right] = str_split((string)$stone, (int)(strlen((string)$stone) / 2));
            $count = $this->blink((int)$left, $iter - 1) + $this->blink((int)$right, $iter - 1);
        } else {
            $count = $this->blink($stone * 2024, $iter - 1);
        }

        $this->cache[$cacheKey] = $count;

        return $count;
    }
}

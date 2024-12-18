<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day01 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    private const SEP = '   ';
    private array $rightCounts = [];

    public function part1(): void
    {
        [$left, $right] = $this->getLists();
        sort($left);
        sort($right);

        $totalDistance = 0;
        for ($i = 0; $i < count($left); $i++) {
            $totalDistance += abs($left[$i] - $right[$i]);
        }

        $this->log(sprintf('Total distance: %d', $totalDistance));
    }

    public function part2(): void
    {
        $similarityScore = 0;
        [$left, $right] = $this->getLists();
        $this->rightCounts = array_count_values($right);
        foreach ($left as $leftNum) {
            $count = $this->rightCounts[$leftNum] ?? 0;
            $similarityScore += $leftNum * $count;
        }

        $this->log(sprintf('Similarity score: %s', $similarityScore));
    }

    private function getLists(): array
    {
        $left = [];
        foreach ($this->input as $line) {
            [$left[], $right[]] = explode(self::SEP, $line);
        }

        return [$left, $right];
    }
}

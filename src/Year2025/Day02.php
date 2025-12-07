<?php

declare(strict_types=1);

namespace AdventOfCode\Year2025;

use AdventOfCode\AbstractDay;

class Day02 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    public function part1(): void
    {
        $ranges = explode(',', $this->input[0]);
        $invalidIdsSum = 0;
        foreach ($ranges as $range) {
            $invalidIdsSum += array_sum($this->findInvalidIdsInRange($range));
        }

        $this->log(sprintf('Found invalid IDs with total sum %d', $invalidIdsSum));
    }

    public function part2(): void
    {
        $ranges = explode(',', $this->input[0]);
        $invalidIdsSum = 0;
        foreach ($ranges as $range) {
            $invalidIdsSum += array_sum($this->findMoreInvalidIdsInRange($range));
        }

        $this->log(sprintf('Found invalid IDs with total sum %d', $invalidIdsSum));
    }

    /** @return int[] */
    private function findInvalidIdsInRange(string $range): array
    {
        $invalidIds = [];
        [$start, $end] = explode('-', $range);
        for ($id = $start; $id <= $end; $id++) {
            if (preg_match('/^(\d+)\1$/', strval($id)) === 1) {
                $invalidIds[] = $id;
            }
        }

        return $invalidIds;
    }

    private function findMoreInvalidIdsInRange(string $range): array
    {
        $invalidIds = [];
        [$start, $end] = explode('-', $range);
        for ($id = $start; $id <= $end; $id++) {
            if (preg_match('/^(\d+)\1+$/', strval($id)) === 1) {
                $invalidIds[] = $id;
            }
        }

        return $invalidIds;
    }
}

<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day02 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    public function part1(): void
    {
        $totalSqft = 0;
        foreach ($this->input as $present) {
            [$l, $w, $h] = array_map('intval', explode('x', $present));
            $sqft = 2*$l*$w + 2*$l*$h + 2*$w*$h + $this->getSlack($l, $w, $h);
            $this->debug(sprintf('Present %s needs %d sqft wrapping paper', $present, $sqft));
            $totalSqft += $sqft;
        }

        $this->log(sprintf('Total wrapping paper needed: %d sqft', $totalSqft));
    }

    public function part2(): void
    {
        $totalFt = 0;
        foreach ($this->input as $present) {
            [$l, $w, $h] = array_map('intval', explode('x', $present));
            $ribbonFt = $l*$w*$h + $this->getBow($l, $w, $h);
            $this->debug(sprintf('Present %s needs %d ft of ribbon', $present, $ribbonFt));
            $totalFt += $ribbonFt;
        }

        $this->log(sprintf('Total ribbon needed: %d ft', $totalFt));
    }

    private function getSlack(int $l, int $w, int $h): int
    {
        return $l*$w*$h / max($l, $w, $h);
    }

    private function getBow(int $l, int $w, int $h): int
    {
        return 2*$l + 2*$w + 2*$h - 2*max($l, $w, $h);
    }
}

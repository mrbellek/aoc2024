<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;
use AdventOfCode\Traits\MatrixTrait;

class Day10 extends AbstractDay
{
    use MatrixTrait;

    public function part1(): void
    {
        $trailEnds = $this->findTrailEnds();
        var_dump($trailEnds);
        //????
        die('unfinished!');
    }

    private function findTrailEnds(): array
    {
        $trailEnds = [];
        foreach ($this->matrix as $y => $line) {
            $x = array_search('9', $line);
            if ($x !== false) {
                $trailEnds[] = [$x, $y];
            }
        }

        return $trailEnds;
    }
}
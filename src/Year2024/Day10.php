<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day10 extends AbstractDay
{
    private array $matrix;

    public function part1(): void
    {
        $this->createMatrix();
        $trailEnds = $this->findTrailEnds();
        var_dump($trailEnds);
        //????
    }

    private function createMatrix(): void
    {
        foreach ($this->input as $y => $line) {
            $this->matrix[$y] = str_split($line, 1);
        }
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
<?php

declare(strict_types=1);

namespace AdventOfCode\Year2025;

use AdventOfCode\AbstractDay;
use AdventOfCode\Traits\MatrixTrait;

class Day04 extends AbstractDay
{
    use MatrixTrait;

    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    public function part1(): void
    {
        $numAccessible = 0;
        foreach ($this->matrix as $y => $row) {
            foreach ($row as $x => $cell) {
                if ($cell === '@') {
                    $neighbourCount = $this->findNeighbourCount($x, $y);
                    if ($neighbourCount < 4) {
                        $numAccessible++;
                    }
                }
            }
        }

        $this->log(sprintf('There are %d rolls accessible', $numAccessible));
    }

    public function part2(): void
    {
        /**
         * TODO:
         * - check how many can be removed in current state
         * - remove them, add to count
         * - repeat
         * - if 0 can be removed, done
         */
        $removedTotal = 0;
        do {
            $removed = $this->removeAccessibleCells();
            $removedTotal += $removed;
        } while ($removed > 0);

        $this->log(sprintf('A total of %d rolls were removed.', $removedTotal));
    }

    private function removeAccessibleCells(): int
    {
        $removed = 0;
        $matrixCopy = $this->matrix;
        foreach ($matrixCopy as $y => $row) {
            foreach ($row as $x => $cell) {
                if ($cell === '@' && $this->isAccessible($x, $y)) {
                    $matrixCopy[$y][$x] = '.';
                    $removed++;
                }
            }
        }
        $this->matrix = $matrixCopy;

        return $removed;
    }

    private function findNeighbourCount(int $x, int $y): int
    {
        $score = 
            (($this->matrix[$y-1][$x] ?? '.') === '@' ? 1 : 0) +
            (($this->matrix[$y-1][$x+1] ?? '.') === '@' ? 1 : 0) +
            (($this->matrix[$y][$x+1] ?? '.') === '@' ? 1 : 0) +
            (($this->matrix[$y+1][$x+1] ?? '.') === '@' ? 1 : 0) +
            (($this->matrix[$y+1][$x] ?? '.') === '@' ? 1 : 0) +
            (($this->matrix[$y+1][$x-1] ?? '.') === '@' ? 1 : 0) +
            (($this->matrix[$y][$x-1] ?? '.') === '@' ? 1 : 0) +
            (($this->matrix[$y-1][$x-1] ?? '.') === '@' ? 1 : 0)
        ;

        $this->debug(sprintf('Roll at %d,%d has %d neighbours', $x, $y, $score));

        return $score;
    }

    private function isAccessible(int $x, int $y): bool
    {
        return $this->findNeighbourCount($x, $y) < 4;
    }
}

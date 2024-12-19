<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;
use AdventOfCode\MatrixTrait;

class Day06 extends AbstractDay
{
    use MatrixTrait;

    public const PART1_COMPLETE = true;

    private const SLEEP_TIME = 100_000;

    public function part1(): void
    {
        $this->debug('Guard start walk!');
        $this->printMatrix();

        $outOfBounds = false;
        while ($outOfBounds === false) {
            [$x, $y] = $this->getGuardPosition();
            if ($this->isGuardObstructed($x, $y) === false) {
                $newpos = $this->moveGuard($x, $y);
            } else {
                $this->rotateGuard($x, $y);
                $newpos = $this->moveGuard($x, $y);
            }
            $this->printMatrix();
            if ($this->isGuardOutOfBounds($newpos)) {
                $outOfBounds = true;
            }
        }

        //tally total number of spots that guard moved in (or is in)
        $steppedSpots = 1;
        foreach ($this->matrix as $y => $line) {
            $steppedSpots += substr_count(implode('', $line), 'X');
        }

        $this->log(sprintf('The guard occupied %d spots before moving out of bounds' . PHP_EOL, $steppedSpots));
        $this->isLive = false;
        $this->printMatrix();
    }

    private function printMatrix(): void
    {
        if ($this->isLive) {
            //speed up the process a bit
            return;
        }

        foreach ($this->matrix as $line) {
            print(implode('', $line)) . PHP_EOL;
        }
        usleep(self::SLEEP_TIME);
    }

    private function getGuardPosition(): array
    {
        foreach ($this->matrix as $y => $line) {
            foreach ($line as $x => $char) {
                if (in_array($char, ['^', '>', '<', 'v'])) {
                    return [$x, $y];
                }
            }
        }

        die('guard not found' . PHP_EOL);
    }

    private function isGuardObstructed(int $x, int $y): bool
    {
        $guardChar = $this->matrix[$y][$x];
        switch ($guardChar) {
            case 'v': return $this->matrix[$y+1][$x] === '#';
            case '>': return $this->matrix[$y][$x+1] === '#';
            case '<': return $this->matrix[$y][$x-1] === '#';
            case '^': return $this->matrix[$y-1][$x] === '#';
            default: die('invalid guard position' . PHP_EOL);
        }
    }

    private function moveGuard(int $x, int $y): array
    {
        $this->debug(sprintf('Guard moving forward.' . PHP_EOL));
        $guardChar = $this->matrix[$y][$x];

        //mark last guard position
        $this->matrix[$y][$x] = 'X';

        switch ($guardChar) {
            case 'v': $this->matrix[$y+1][$x] = $guardChar; return [$x, $y+1];
            case '>': $this->matrix[$y][$x+1] = $guardChar; return [$x+1, $y];
            case '<': $this->matrix[$y][$x-1] = $guardChar; return [$x-1, $y];
            case '^': $this->matrix[$y-1][$x] = $guardChar; return [$x, $y-1];
            default: die('invalid guard position' . PHP_EOL);
        }
    }

    private function rotateGuard(int $x, int $y): void
    {
        $this->debug(sprintf('Guard turning right and moving forward.' . PHP_EOL));
        $guardChar = $this->matrix[$y][$x];
        switch ($guardChar) {
            case 'v': $this->matrix[$y][$x] = '<'; break;
            case '>': $this->matrix[$y][$x] = 'v'; break;
            case '<': $this->matrix[$y][$x] = '^'; break;
            case '^': $this->matrix[$y][$x] = '>'; break;
            default: die('invalid guard position' . PHP_EOL);
        }
    }

    private function isGuardOutOfBounds($newpos): bool
    {
        $this->debug('Guard is out of bounds!' . PHP_EOL);
        [$x, $y] = $newpos;
        $guardChar = $this->matrix[$y][$x];

        if (
            $guardChar === '^' && $y === 0 ||
            $guardChar === 'v' && $y === count($this->matrix) - 1 ||
            $guardChar === '>' && $x === count($this->matrix[0]) - 1 ||
            $guardChar === '<' && $x === 0
        ) {
            return true;
        }

        return false;
    }
}
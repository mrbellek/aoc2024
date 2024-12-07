<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day06 extends AbstractDay
{
    private array $matrix = [];
    private bool $isLive = false;
    private const SLEEP_TIME = 100_000;

    public function __construct(string $dataSet)
    {
        parent::__construct($dataSet);
        $this->isLive = $dataSet === 'live';
    }

    public function part1(): void
    {
        $this->createMatrix();

        print('Guard start walk!' . PHP_EOL . PHP_EOL);
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

        printf('The guard occupied %d spots before moving out of bounds'. PHP_EOL . PHP_EOL, $steppedSpots);
        $this->isLive = false;
        $this->printMatrix();
    }

    public function part2(): void
    {
        $this->createMatrix();
    }

    private function createMatrix(): void
    {
        foreach ($this->input as $i => $line) {
            $this->matrix[$i] = str_split($line);
        }
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
        if ($this->isLive === false) {
            printf('Guard moving forward.' . PHP_EOL . PHP_EOL);
        }
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
        if ($this->isLive === false) {
            printf('Guard turning right and moving forward.' . PHP_EOL . PHP_EOL);
        }
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
        if ($this->isLive === false) {
            print('Guard is out of bounds!' . PHP_EOL . PHP_EOL);
        }
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
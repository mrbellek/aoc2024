<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;
use AdventOfCode\Traits\MatrixTrait;
use AdventOfCode\Traits\PermutationTrait;

class Day18 extends AbstractDay
{
    use MatrixTrait;

    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = false;

    public function part1(): void
    {
        $this->createMatrix();
        $this->printMatrix();

        $stepCount = $this->isLive ? 100 : 4;
        for ($i = 0; $i < $stepCount; $i++) {
            $this->animate();
            $this->printMatrix();
            if ($this->isLive === false) {
                usleep(200_000);
            }
        }

        $this->log(sprintf('The matrix has %d lights on after %d steps.',
            $this->getLitCount(),
            $stepCount
        ));
    }

    public function part2(): void
    {
        $this->createMatrix();
        $this->matrix[0][0] = '#';
        $this->matrix[0][count($this->matrix[0])-1] = '#';
        $this->matrix[count($this->matrix)-1][0] = '#';
        $this->matrix[count($this->matrix)-1][count($this->matrix[0])-1] = '#';
        $this->printMatrix();

        $stepCount = $this->isLive ? 100 : 5;
        for ($i = 0; $i < $stepCount; $i++) {
            $this->animate(true);
            $this->printMatrix();
            if ($this->isLive === false) {
                usleep(200_000);
            }
        }

        $this->log(sprintf('The corrected matrix has %d lights on after %d steps.',
            $this->getLitCount(),
            $stepCount
        ));

    }

    private function animate(bool $lockCorners = false): void
    {
        $newMatrix = $this->matrix;
        foreach ($this->matrix as $y => $line) {
            foreach ($line as $x => $light) {
                if ($this->isCorner($x, $y)) {
                    continue;
                }
                $newMatrix[$y][$x] = $this->getNewLightState($x, $y) ? '#' : '.';
//                $this->fatal('ligth at ' . $x . ',' . $y . ' has new state ' . $newMatrix[$y][$x]);
            }
        }

        $this->matrix = $newMatrix;
    }

    private function getNewLightState(int $x, int $y): bool
    {
        $neighbourCount = $this->getNeighbourOnCount($x, $y);
//        $this->debug('light at ' . $x . ',' . $y . ' has ' . $neighbourCount . ' ON neighbours');
        if ($this->matrix[$y][$x] === '#') {
            //lights that are on:
            //- stays on if 2 or 3 neighbours are on
            //- turns off otherwise
            return $neighbourCount === 2 || $neighbourCount === 3;

        } else {
            //lights that are off:
            //- turns on if 3 neighbours are on
            //- stays off otherwise
            return $neighbourCount === 3;
        }
    }

    private function printMatrix(): void
    {
        foreach ($this->matrix as $line) {
            $this->log(implode('', $line));
        }
        echo PHP_EOL;
    }

    private function getNeighbourOnCount(int $x, int $y): int
    {
        //check all 8 surrounding lights
        //if a light doesnt exist (i.e. too close to border) it is 'off'
        $neighboursOn = 0;

        //straight left
        if (($this->matrix[$y][$x-1] ?? '') === '#') {
            $neighboursOn++;
        }
        //top left
        if (($this->matrix[$y-1][$x-1] ?? '') === '#') {
            $neighboursOn++;
        }
        //straight top
        if (($this->matrix[$y-1][$x] ?? '') === '#') {
            $neighboursOn++;
        }
        //top right
        if (($this->matrix[$y-1][$x+1] ?? '') === '#') {
            $neighboursOn++;
        }
        //straight right
        if (($this->matrix[$y][$x+1] ?? '') === '#') {
            $neighboursOn++;
        }
        //bottom right
        if (($this->matrix[$y+1][$x+1] ?? '') === '#') {
            $neighboursOn++;
        }
        //straight bottom
        if (($this->matrix[$y+1][$x] ?? '') === '#') {
            $neighboursOn++;
        }
        //bottom left
        if (($this->matrix[$y+1][$x-1] ?? '') === '#') {
            $neighboursOn++;
        }

        return $neighboursOn;
    }

    private function getLitCount(): int
    {
        $count = 0;
        foreach ($this->matrix as $line) {
            $count += substr_count(implode('', $line), '#');
        }

        return $count;
    }

    private function isCorner(int $x, int $y): bool
    {
        $maxX = count($this->matrix[0]) - 1;
        $maxY = count($this->matrix) - 1;

        if ($x === 0 && $y === 0) {
            return true;
        } elseif ($x === $maxX && $y === 0) {
            return true;
        } elseif ($x === 0 && $y === $maxY) {
            return true;
        } elseif ($x === $maxX && $y === $maxY) {
            return true;
        }

        return false;
    }
}

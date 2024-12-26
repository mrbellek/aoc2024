<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day03 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    private array $matrix;

    public function part1(): void
    {
        $x = 0;
        $y = 0;
        $this->matrix[$y][$x] = 1;
        foreach (str_split(implode(PHP_EOL, $this->input)) as $direction) {
            [$newX, $newY] = $this->deliverPresent($direction, $x, $y);
            $x = $newX;
            $y = $newY;
        }

        $total = 0;
        foreach ($this->matrix as $y => $line) {
            foreach ($line as $x => $count) {
                $this->debug(sprintf('[%d,%d] %d presents', $x, $y, $count));
                $total++;
            }
        }
        $this->log(sprintf('%d houses have a least one present.', $total));
    }
    
    public function part2(): void
    {
        $santaX = 0;
        $santaY = 0;
        $roboX = 0;
        $roboY = 0;
        $this->matrix[$santaY][$santaX] = 1;
        foreach (str_split(implode(PHP_EOL, $this->input)) as $i => $direction) {
            if ($i % 2 === 0) {
                //santa delivery
                [$newX, $newY] = $this->deliverPresent($direction, $santaX, $santaY);
                $santaX = $newX;
                $santaY = $newY;
            } else {
                //robosanta delivery
                [$newX, $newY] = $this->deliverPresent($direction, $roboX, $roboY);
                $roboX = $newX;
                $roboY = $newY;
            }
        }

        $total = 0;
        foreach ($this->matrix as $y => $line) {
            foreach ($line as $x => $count) {
                $this->debug(sprintf('[%d,%d] %d presents', $x, $y, $count));
                $total++;
            }
        }
        $this->log(sprintf('%d houses have a least one present.', $total));
    }

    private function deliverPresent(string $direction, int $x, int $y): array
    {
        switch ($direction) {
            case '>': $x++; break;
            case '<': $x--; break;
            case '^': $y--; break;
            case 'v': $y++; break;
            default: die('wtf: ' . $direction);
        }

        if (!isset($this->matrix[$y][$x])) {
            $this->matrix[$y][$x] = 0;
        }
        $this->matrix[$y][$x]++;

        return [$x, $y];
    }
}

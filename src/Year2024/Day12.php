<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;
use AdventOfCode\MatrixTrait;

class Day12 extends AbstractDay
{
    use MatrixTrait;
    
    private array $gardens = [];

    public function part1(): void
    {
        //divide all squares into gardens
        foreach ($this->matrix as $y => $line) {
            foreach ($line as $x => $char) {
                if (!array_key_exists($char, $this->gardens)) {
                    // There can be multiple plots with the same plant
                    // that do not share a border
                    $this->gardens[$char] = [0 => []];
                }

                //Check which plot this square belongs to
                $plotFound = false;
                foreach ($this->gardens[$char] as $index => $plot) {
                    if ($this->pointBordersOnPlot($x, $y, $plot, $char)) {
                        $plotFound = true;
                        $this->gardens[$char][$index][] = [$x, $y];
                        break;
                    }
                }

                //If no plot found, create a new one
                if (!$plotFound) {
                    $this->gardens[$char][$index+1][] = [$x, $y];
                }
            }
        }
        die('stop');

        //calculate total price, price per garden is area * perimeter
        $totalPrice = 0;
        foreach ($this->gardens as $char => $charGardens) {
            foreach ($charGardens as $index => $garden) {
                $area = $this->getGardenArea($garden);
                $perimeter = $this->getGardenPerimeter($garden);
                $totalPrice += $area * $perimeter;
                $this->debug(sprintf('Garden %s has area %d and perimeter %d, price is %d',
                    $char,
                    $area,
                    $perimeter,
                    $area * $perimeter
                ));
            }
        }
        
        $this->log(sprintf('There are %d gardens in the plot, the total fencing price is %s.', count($this->gardens), $totalPrice));
    }

    private function getGardenArea(array $garden): int
    {
        return count($garden);
    }

    private function getGardenPerimeter(array $garden): int
    {
        // The perimeter of a garden is equal to a rectangle
        // drawn around its farthest points
        $minX = min(array_column($garden, 0));
        $maxX = max(array_column($garden, 0));
        $minY = min(array_column($garden, 1));
        $maxY = max(array_column($garden, 1));

        return ($maxX - $minX + 1) * 2 + ($maxY - $minY + 1) * 2;
    }

    private function pointBordersOnPlot(int $x, int $y, array $plot, string $char): bool
    {
        if (count($plot) === 0) {
            return true;
        }

        //if a plot point neighbours on the given point,
        //either X1 = X2 and Y1 = Y2+1 or Y1 = Y2-1,
        //or Y1 = Y2 and X1 = X2+1 or X1 = X2-1
        foreach ($plot as [$plotX, $plotY]) {
            if (
                $plotX === $x && abs($plotY - $y) === 1 ||
                $plotY === $y && abs($plotX - $x) === 1 
            ) {
                return true;
            }
        }

        $this->debug(sprintf('Unable to find a neighbouring plot for plant %s for point [%d,%d]', $char, $x, $y));
        return false;
    }
}
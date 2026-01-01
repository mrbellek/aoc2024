<?php

declare(strict_types=1);

namespace AdventOfCode\Year2025;

use AdventOfCode\AbstractDay;

class Day09 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = false;

    private array $floor = [];
    private array $redTiles = [];

    public function part1(): void
    {
        $this->parseInput();
        $this->printFloor();

        $maxSurface = 0;
        $maxSurfaceTile1 = [];
        $maxSurfaceTile2 = [];
        foreach ($this->redTiles as $i => $redTile1) {
            foreach ($this->redTiles as $j => $redTile2) {
                if ($i === $j) {
                    continue;
                }
                $surface = $this->calcSurface($redTile1, $redTile2);
                $this->debug(sprintf(
                    'Rect between (%d,%d) and (%d,%d) is surface area %d',
                        $redTile1[0],
                        $redTile1[1],
                        $redTile2[0],
                        $redTile2[1],
                        $surface,
                ));
                if ($surface > $maxSurface) {
                    $maxSurface = $surface;
                    $maxSurfaceTile1 = $redTile1;
                    $maxSurfaceTile2 = $redTile2;
                }
            }
        }

        $this->log(sprintf(
            'The largest rect was between (%d,%d) and (%d,%d) at size %d',
            $maxSurfaceTile1[0],
            $maxSurfaceTile1[1],
            $maxSurfaceTile2[0],
            $maxSurfaceTile2[1],
            $maxSurface,
        ));
    }

    private function calcSurface(array $tile1, array $tile2): int
    {
        return (abs($tile1[0] - $tile2[0]) + 1) * (abs($tile1[1] - $tile2[1]) + 1);
    }

    private function parseInput(): void
    {
        $maxX = 0;
        $maxY = 0;
        foreach ($this->input as $i => $redTileRaw) {
            $redTile = explode(',', $redTileRaw);
            $maxX = max($maxX, $redTile[0]);
            $maxY = max($maxY, $redTile[1]);
            $this->redTiles[] = $redTile;
        }

        //disabled because I ran out of memory lol
        /*for ($i = 0; $i <= $maxY; $i++) {
            $this->floor[] = array_fill(0, $maxX + 1, '.');
        }
        foreach ($this->redTiles as $redTile) {
            [$x, $y] = $redTile;
            $this->floor[$y][$x] = '#';
        }*/
    }

    private function printFloor(): void
    {
        if ($this->isLive) {
            return;
        }
        foreach ($this->floor as $row) {
            print(implode('', $row) . PHP_EOL);
        }
    }
}

<?php

declare(strict_types=1);

namespace AdventOfCode\Year2025;

use AdventOfCode\AbstractDay;

class Day09 extends AbstractDay
{
    public const PART1_COMPLETE = false;
    public const PART2_COMPLETE = false;

    private array $floor = [];
    private array $redTiles = [];

    public function part1(): void
    {
        $this->parseInput();

        [$answer, $tileIndex1, $tileIndex2] = $this->findLargestRect();
        $this->log(sprintf(
            'The largest possible rectangle is between red tile %d and %d and is %d in size.',
            $tileIndex1, $tileIndex2, $answer,
        ));
    }

    private function parseInput(): void
    {
        $redTiles = [];
        $maxX = 0;
        $maxY = 0;
        foreach ($this->input as $line) {
            //tile is going to be [X,Y] coordinates, zero-based
            $tile = explode(',', $line);
            $this->redTiles[] = $tile;
            $maxX = max($maxX, (int)$tile[0]);
            $maxY = max($maxY, (int)$tile[1]);
        }

        //create floor
        for ($i = 0; $i <= $maxY; $i++) {
            $this->floor[] = array_fill(0, $maxX + 1, '.');
        }

        //create red tiles
        foreach ($this->redTiles as $tile) {
            $this->floor[$tile[1]][$tile[0]] = '#';
        }
    }

    private function printFloor(): void
    {
        foreach ($this->floor as $line) {
            $this->log(implode('', $line));
        }
    }

    private function findLargestRect(): array
    {
        $maxSurface = 0;
        $maxSurfaceIndeces = [-1, -1];
        foreach ($this->redTiles as $i => $tile1) {
            foreach ($this->redTiles as $j => $tile2) {
                if ($i === $j) {
                    continue;
                }

                $surface = abs($tile1[0] - $tile2[0]+1) * abs($tile1[1] - $tile2[1]+1);
                $this->debug(sprintf(
                    'Surface between [%d,%d] and [%d,%d] is %d',
                    $tile1[0],
                    $tile1[1],
                    $tile2[0],
                    $tile2[1],
                    $surface,
                ));
                if ($surface > $maxSurface) {
                    $maxSurface = $surface;
                    $maxSurfaceIndeces = [$i, $j];
                }
            }
        }

        $this->debug(sprintf(
            'Max surface corners are [%d,%d] and [%d,%d]',
            $this->redTiles[$maxSurfaceIndeces[0]][0],
            $this->redTiles[$maxSurfaceIndeces[0]][1],
            $this->redTiles[$maxSurfaceIndeces[1]][0],
            $this->redTiles[$maxSurfaceIndeces[1]][1],
        ));
        $this->floor[$this->redTiles[$i][1]][$this->redTiles[$i][0]] = 'O';
        $this->floor[$this->redTiles[$j][1]][$this->redTiles[$j][0]] = 'O';
        $this->printFloor();

        return [$maxSurface, $maxSurfaceIndeces[0], $maxSurfaceIndeces[1]];
    }
}
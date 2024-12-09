<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

use function array_column;

class Day08 extends AbstractDay
{
    private array $matrix = [];

    public function __construct(string $dataSet)
    {
        parent::__construct($dataSet);
        $this->createMatrix();
    }

    public function part1(): void
    {
        //how many of the nodes in the matrix have an anti-node?
        $nodes = $this->findNodes();
        $antinodes = [];
        foreach ($nodes as $node1) {
            foreach ($nodes as $node2) {
                if ($node1['x'] === $node2['x'] && $node1['y'] === $node2['y']) {
                    //don't compare node against itself
                    continue;
                }
                if ($node1['char'] !== $node2['char']) {
                    //only compare nodes of the same frequency (same character)
                    continue;
                }

                [$antinode1, $antinode2] = $this->findAntinodes($node1, $node2);
                if (!$this->isPointOutOfBounds($antinode1)) {
                    $antinodes[] = $antinode1;
                }
                if (!$this->isPointOutOfBounds($antinode2)) {
                    $antinodes[] = $antinode2;
                }
            }
        }

        $antinodes = $this->getUniqueNodes($antinodes);
        $this->printMatrixWithAntinodes($antinodes);
        printf('There are %d unique locations on the map with antinodes.', count($antinodes));
    }

    public function part2(): void
    {

    }

    private function findNodes(): array
    {
        $nodes = [];
        foreach ($this->matrix as $y => $line) {
            $matches = [];
            echo implode('', $line) . PHP_EOL;
            if (preg_match_all('/([^.])/', implode('', $line), $matches, PREG_OFFSET_CAPTURE) > 0) {
                foreach ($matches[0] as $match) {
                    $char = $match[0];
                    $x = $match[1];
                    $nodes[] = ['char' => $char, 'x' => $x, 'y' => $y];
                }
            }
        }

        return $nodes;
    }
    
    private function findAntinodes(array $node1, array $node2): array
    {
        //antinodes appear for any pair of nodes, the same distance away
        //from either one as the other node is
        //e.g. #...A...A...# (hor/vert/diag)
        $dx = $node2['x'] - $node1['x'];
        $dy = $node2['y'] - $node1['y'];

        $antinode1 = [
            'char' => '#',
            'x' => $node1['x'] - $dx,
            'y' => $node1['y'] - $dy
        ];

        $antinode2 = [
            'char' => '#',
            'x' => $node2['x'] + $dx,
            'y' => $node2['y'] + $dy
        ];

        return [$antinode1, $antinode2];
    }
    
    private function isPointOccupied(array $node): bool
    {
        return $this->matrix[$node['y']][$node['x']] !== '.';
    }

    private function isPointOutOfBounds(array $node): bool
    {
        return $node['x'] < 0 ||
            $node['y'] < 0 ||
            $node['x'] > count($this->matrix[0]) - 1 ||
            $node['y'] > count($this->matrix) - 1;
    }

    private function printMatrixWithAntinodes(array $antinodes): void
    {
        print(PHP_EOL . 'With antinodes:' . PHP_EOL . PHP_EOL);
        $matrix = $this->matrix;
        foreach ($antinodes as $antinode) {
            if (!$this->isPointOccupied($antinode)) {
                $matrix[$antinode['y']][$antinode['x']] = '#';
            }
        }
        foreach ($matrix as $y => $line) {
            print(implode('', $line) . PHP_EOL);
        }
    }

    private function getUniqueNodes(array $nodes): array
    {
        $uniqueNodes = [];
        foreach ($nodes as $node) {
            $key = $node['x'] . $node['y'];
            $uniqueNodes[$key] = $node;
        }

        return $uniqueNodes;
    }
    
    private function createMatrix(): void
    {
        foreach ($this->input as $y => $line) {
            $this->matrix[$y] = str_split($line);
        }
    }
}

<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;
use AdventOfCode\Traits\PermutationTrait;

class Day09 extends AbstractDay
{
    use PermutationTrait;
    
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    private array $distances;

    public function part1(): void
    {
        $this->parseRoutes();

        $routes = [];
        foreach ($this->getPermutations(array_keys($this->distances)) as $permutation) {
            $routes[implode('.', $permutation)] = $this->calculateDistance($permutation);
        }
        arsort($routes);
        $this->log(sprintf('Out of %d possible routes, the shortest one is %d',
            count($routes),
            end($routes)
        ));
        $this->log(array_key_last($routes));
    }

    public function part2(): void
    {
        $this->parseRoutes();

        $routes = [];
        foreach ($this->getPermutations(array_keys($this->distances)) as $permutation) {
            $routes[implode('.', $permutation)] = $this->calculateDistance($permutation);
        }
        asort($routes);
        $this->log(sprintf('Out of %d possible routes, the longest one is %d',
            count($routes),
            end($routes)
        ));
        $this->log(array_key_last($routes));
    }

    private function calculateDistance(array $locations): int
    {
        $totalDistance = 0;
        for ($i = 0; $i < count($locations) - 1; $i++) {
            if (isset($this->distances[$locations[$i]][$locations[$i+1]])) {
                $distance = $this->distances[$locations[$i]][$locations[$i+1]];

            } elseif (isset($this->distances[$locations[$i+1]][$locations[$i]])) {
                $distance = $this->distances[$locations[$i+1]][$locations[$i]];
            } else {
                $this->fatal(sprintf('cannot find distance between %s and %s', $locations[$i], $locations[$i+1]));
            }
            $totalDistance += $distance;
        }

        return $totalDistance;
    }

    private function parseRoutes(): void
    {
        foreach ($this->input as $line) {
            $m = [];
            if (preg_match('/(\w+) to (\w+) = (\d+)/', $line, $m) === 1) {
                $this->distances[$m[1]][$m[2]] = $m[3];
                $this->distances[$m[2]][$m[1]] = $m[3];
            } else {
                $this->fatal(sprintf('unable to parse: %s', $line));
            }
        }
    }
}

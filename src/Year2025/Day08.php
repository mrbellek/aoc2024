<?php

declare(strict_types=1);

namespace AdventOfCode\Year2025;

use AdventOfCode\AbstractDay;

/**
 * TODO
 * - optimize by caching distances? now runs 12s on live data for first 10 connections lmao
 * - keyed by floor(distance)?
 */
class Day08 extends AbstractDay
{
    public const PART1_COMPLETE = false;
    public const PART2_COMPLETE = false;
    
    private array $circuits = [];

    public function part1(): void
    {
        define('MAX_CONN', $this->isLive ? 1000 : 10);
        $boxes = $this->parseInput();

        $numConnections = 0;
        do {
            [$boxA, $boxB] = $this->findClosestUnconnectedPair($boxes);
            $connected = $this->addConnectionToCircuits($boxA, $boxB);
            $numConnections += $connected ? 1 : 0;
        } while ($numConnections <= MAX_CONN);

        echo PHP_EOL;
        $this->log(sprintf('There are %d circuits', count($this->circuits)));
        $circuitSizes = [];
        foreach ($this->circuits as $i => $circuit) {
            $circuitSizes[$i] = count($circuit);
            $this->log(sprintf('Circuit %d has %d boxes', $i, count($circuit)));
        }
        arsort($circuitSizes);
        $top3Product = array_product(array_slice($circuitSizes, 0, 3));
        $this->log(sprintf('The product of the sizes of the three largest circuits is %d', $top3Product));
    }

    private function findClosestUnconnectedPair(array $boxes): array
    {
        $minEuclidDist = PHP_FLOAT_MAX;
        $minEuclidDistPair = [];
        $this->debug('Finding next closest unconnected pair of boxes..');
        foreach ($boxes as $boxA) {
            foreach ($boxes as $boxB) {
                if ($boxA === $boxB) {
                    continue;
                }
                if ($this->isConnectionInAnyCircuit($boxA, $boxB)) {
                    continue;
                }
                
                $euclidDist = $this->euclidDist($boxA, $boxB);
                if ($euclidDist < $minEuclidDist) {
                    $minEuclidDist = $euclidDist;
                    $minEuclidDistPair = [$boxA, $boxB];
                }
            }
        }

        $this->debug(sprintf(
            'Found box %s and box %s at %f',
            implode(',', $minEuclidDistPair[0]),
            implode(',', $minEuclidDistPair[1]),
            $minEuclidDist,
        ));

        return $minEuclidDistPair;
    }

    private function isConnectionInCircuit(array $boxA, array $boxB, array $circuit): bool
    {
        return in_array($boxA, $circuit) && in_array($boxB, $circuit);
    }

    private function isConnectionInAnyCircuit(array $boxA, array $boxB): bool
    {
        foreach ($this->circuits as $circuit) {
            if ($this->isConnectionInCircuit($boxA, $boxB, $circuit)) {
                return true;
            }
        }

        return false;
    }

    private function addConnectionToCircuits(array $boxA, array $boxB): bool
    {
        if ($this->isConnectionInAnyCircuit($boxA, $boxB)) {
            $this->debug('Boxes are alread in a circuit together, skipping');
            return false;
        }

        foreach ($this->circuits as $i => $circuit) {
            if (in_array($boxA, $circuit) || in_array($boxB, $circuit)) {
                $this->debug('One of the boxes is already in a circuit, adding the other one!');
                $this->circuits[$i][] = $boxA;
                $this->circuits[$i][] = $boxB;
                $this->circuits[$i] = array_map('unserialize', array_unique(array_map('serialize', $this->circuits[$i])));
                return true;
            }
        }

        //neither box is in a circuit, so make a new circuit
        $this->debug('Creating new circuit for boxes.');
        $this->circuits[] = [$boxA, $boxB];

        return true;
    }

    private function parseInput(): array
    {
        $boxes = [];
        foreach ($this->input as $box) {
            $boxes[] = explode(',', $box);
        }

        return $boxes;
    }

    private function euclidDist(array $pointA, array $pointB): float
    {
        $x = $pointA[0] - $pointB[0];
        $y = $pointA[1] - $pointB[1];
        $z = $pointA[2] - $pointB[2];

        return sqrt(pow($x, 2) + pow($y, 2) + pow($z, 2));
    }
}

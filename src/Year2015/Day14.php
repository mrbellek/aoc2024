<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;
use AdventOfCode\Traits\PermutationTrait;

class Day14 extends AbstractDay
{
    private array $reindeer = [];

    public function part1(): void
    {
        $this->parseInput();
        $raceTime = 2503;

        $maxDistance = 0;
        $maxDistanceReindeer = '';
        foreach ($this->reindeer as $name => $reindeer) {
            $distance = $this->getReindeerDistance($name, $raceTime);
            $this->debug(sprintf(
                '%s flew %f km in %d seconds',
                $name,
                $distance,
                $raceTime
            ));
            if ($distance > $maxDistance) {
                $maxDistance = $distance;
                $maxDistanceReindeer = $name;
            }
        }

        $this->log(sprintf(
            'The fastest reindeer is %s, flying %f km in %d seconds.',
            $maxDistanceReindeer,
            $maxDistance,
            $raceTime
        ));
    }

    private function getReindeerDistance(string $name, int $raceTime): float
    {
        //@TODO this is wrong, the reindeer dont fly at a constant speed
        $reindeer = $this->reindeer[$name];
        $speed = floatval($reindeer['speed']) / ($reindeer['fly_time'] + $reindeer['rest_time']);

        return $speed * $raceTime;
    }

    private function parseInput(): void
    {
        foreach ($this->input as $line) {
            if (preg_match('/^(\w+) can fly (\d+) km\/s for (\d+) seconds, but then must rest for (\d+) seconds\.$/', $line, $m) === 1) {
                $this->reindeer[$m[1]] = [
//                    'name' => $m[1],
                    'speed' => $m[2],
                    'fly_time' => $m[3],
                    'rest_time' => $m[4],
                ];
            } else {
                die('wtf?');
            }
        }
    }
}

<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day14 extends AbstractDay
{
    public const PART1_COMPLETE = true;

    private array $reindeer = [];

    public function part1(): void
    {
        $this->parseInput();
        if ($this->isLive) {
            $raceTime = 2503;
        } else {
            $raceTime = 1000;
        }

        $maxDistance = 0;
        $maxDistanceReindeer = '';
        foreach ($this->reindeer as $name => $reindeer) {
            $distance = $this->getReindeerDistance($name, $raceTime);
            $this->debug(sprintf(
                '%s flew %d km in %d seconds',
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
            'The fastest reindeer is %s, flying %d km in %d seconds.',
            $maxDistanceReindeer,
            $maxDistance,
            $raceTime
        ));
    }

    private function getReindeerDistance(string $name, int $raceTime): float
    {
        $reindeer = $this->reindeer[$name];
        $cycleTime = $reindeer['fly_time'] + $reindeer['rest_time'];
        $fullCycles = floor($raceTime / $cycleTime);
        $remainingTime = $raceTime % $cycleTime;

        $this->log(sprintf(
            '%s can fly %d full cycles in %d seconds, after which %d seconds are left.',
            $name, $fullCycles, $raceTime, $remainingTime
        ));

        if ($reindeer['fly_time'] < $remainingTime) {
            //remaining time is larger than fly time, but smaller than fly+rest time.
            //solution: add one fly distance and return
            return $reindeer['speed'] * $reindeer['fly_time'] * ($fullCycles + 1);
        } else {
            //remaining tie is smaller than fly time
            //solution: add flying given speed for remaining time
            return $reindeer['speed'] * $reindeer['fly_time'] * $fullCycles + $reindeer['speed'] * $remainingTime;
        }
    }

    private function parseInput(): void
    {
        foreach ($this->input as $line) {
            if (preg_match('/^(\w+) can fly (\d+) km\/s for (\d+) seconds, but then must rest for (\d+) seconds\.$/', $line, $m) === 1) {
                $this->reindeer[$m[1]] = [
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

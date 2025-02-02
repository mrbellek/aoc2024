<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day14 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

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

    public function part2(): void
    {
        $this->parseInput();
        if ($this->isLive) {
            $raceTime = 2503;
        } else {
            $raceTime = 1000;
        }

        $scoreTally = [];
        $distanceThisSecond = [];
        for ($i = 1; $i <= $raceTime; $i++) {
            foreach ($this->reindeer as $name => $reindeer) {
                $distanceThisSecond[$name] = $this->getReindeerDistanceOnSecond($name, $i);
            }
            $leadReindeer = array_keys($distanceThisSecond, max($distanceThisSecond));
            foreach ($leadReindeer as $leadName) {
                if (!isset($scoreTally[$leadName])) {
                    $scoreTally[$leadName] = 0;
                }
                $scoreTally[$leadName]++;
            }
        }

        asort($scoreTally);
        $this->log('Final tally:');
        foreach ($scoreTally as $name => $tally) {
            $this->log(sprintf('%s: %d points', $name, $tally));
        }
    }

    private function getReindeerDistanceOnSecond(string $name, int $second): int
    {
        return $this->getReindeerDistance($name, $second);
    }

    private function getReindeerDistance(string $name, int $raceTime): int
    {
        $reindeer = $this->reindeer[$name];
        $cycleTime = $reindeer['fly_time'] + $reindeer['rest_time'];
        $fullCycles = intval(floor($raceTime / $cycleTime));
        $remainingTime = $raceTime % $cycleTime;

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

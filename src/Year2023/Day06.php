<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023;

use AdventOfCode\AbstractDay;

class Day06 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    public function part1(): void
    {
        $times = array_filter(explode(' ', trim(substr($this->input[0], strpos($this->input[0], ':') + 1))));
        $distances = array_filter(explode(' ', trim(substr($this->input[1], strpos($this->input[1], ':') + 1))));
        
        $races = array_combine($times, $distances);
        $part1Answer = 1;
        foreach ($races as $time => $distance) {
            $part1Answer *= this->findPossibleWinningRaceCount(intval($time), intval($distance));
        }
        $this->log(sprintf('Part 1 answer: %s', $part1Answer));
    }

    public function part2(): void
    {
        $time = str_replace(' ', '', substr($this->input[0], strpos($this->input[0], ':') + 1));
        $distance = str_replace(' ', '', substr($this->input[1], strpos($this->input[1], ':') + 1));
        
        $this->log(sprintf('Part 2 answer: %s', $this->findPossibleWinningRaceCount(intval($time), intval($distance))));
    }

    private function findPossibleWinningRaceCount(int $timeInMs, int $distanceInMm): int
    {
        $this->debug(sprintf('Finding ways to beat record of %d mm in %d ms...', $distanceInMm, $timeInMs));
        $possibleWinCount = 0;
        for ($holdTime = 1; $holdTime < $timeInMs; $holdTime++) {
            $raceTime = $timeInMs - $holdTime;
            $raceDistance = $raceTime * $holdTime;
            if ($raceDistance > $distanceInMm) {
                $possibleWinCount++;
                //$this->debug(sprintf('winning: holding button for %d ms gives a distance of %s!', $raceTime, $raceDistance));
            }
        }
    
        if ($possibleWinCount === 0) {
            $this->debug('none found :(');
        } else {
            $this->debug(sprintf('there are %d ways', $possibleWinCount));
        }
    
        return $possibleWinCount;
    }
}
    

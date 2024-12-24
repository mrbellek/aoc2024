<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023;

use AdventOfCode\AbstractDay;

class Day02 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    public function part1(): void
    {
        $maxRed = 12;
        $maxGreen = 13;
        $maxBlue = 14;
        
        $validCount = 0;
        $sumOfGameIds = 0;
        $sumOfGamePowers = 0;
        foreach ($this->input as $line) {
            $gameInfo = $this->getGameInfo($line);
            if ($this->isGamePossible($gameInfo, $maxRed, $maxGreen, $maxBlue)) {
                $sumOfGameIds += key($gameInfo);
                $validCount++;
            }
        }
        
        $this->log(sprintf('Processed %d games, but only %d were possible with given restrictions, and the sum of game ids was %d.',
            count($this->input),
            $validCount,
            $sumOfGameIds
        ));
    }

    public function part2(): void
    {
        $maxRed = 12;
        $maxGreen = 13;
        $maxBlue = 14;
        
        $validCount = 0;
        $sumOfGameIds = 0;
        $sumOfGamePowers = 0;
        foreach ($this->input as $line) {
            $gameInfo = $this->getGameInfo($line);
            
            $gamePower = $this->getGamePower($gameInfo);
            $sumOfGamePowers += $gamePower;
        }

        $this->log(sprintf('Processed %d games, by their powers combined we got %s', count($this->input), $sumOfGamePowers));
    }

    public function getGamePower(array $gameInfo): int
    {
        $gamePower = 1;
        $highestGreen = 0;
        $highestBlue = 0;
        $highestRed = 0;
        foreach ($gameInfo as $id => $games) {
            foreach ($games as $game) {
                $highestGreen = max($highestGreen, $game['green'] ?? 0);
                $highestBlue = max($highestBlue, $game['blue'] ?? 0);
                $highestRed = max($highestRed, $game['red'] ?? 0);
            }
        }
    
        return $highestRed * $highestBlue * $highestGreen;
    }

    public function getGameInfo(string $line): array
    {
        $gameInfo = [];
        $gameId = intval(str_replace('Game ', '', $line));
        $games = explode(';', substr($line, strpos($line, ':') + 1));
        foreach ($games as $game) {
            $grabs = explode(',', $game);
            $singleGameInfo = [];
            foreach ($grabs as $grab) {
                $numAndColour = explode(' ', trim($grab));
                $singleGameInfo[$numAndColour[1]] = $numAndColour[0];
            }
            $gameInfo[$gameId][] = $singleGameInfo;
        }
    
        return $gameInfo;
    }
    
    public function isGamePossible(array $gamesInfo, int $maxRed, int $maxGreen, int $maxBlue): bool
    {
        foreach ($gamesInfo as $id => $games) {
            foreach ($games as $game) {
                if (($game['green'] ?? 0) > $maxGreen ||
                    ($game['red'] ?? 0) > $maxRed ||
                    ($game['blue'] ?? 0) > $maxBlue
                ) {
                    return false;
                }
            }
        }
    
        return true;
    }
}

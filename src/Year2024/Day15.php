<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day15 extends AbstractDay
{

    public function part1(): void
    {
        [$mazeStr, $botStr] = explode("\n\n", $this->inputStr);
        $maze = [];
        foreach (explode(PHP_EOL, $mazeStr) as $line) {
            $maze[] = str_split($line, 1);
        }
        $this->debug('Starting maze:');
        if (!$this->isLive) {
            $this->printMaze($maze);
        }
        $botInstructions = str_replace(PHP_EOL, '', $botStr);

        $len = strlen($botInstructions);
        for ($i = 0; $i < $len; $i++) {
            [$botX, $botY] = $this->getBotPosition($maze);
            if ($this->botCanMove($maze, $botInstructions[$i], $botX, $botY) === false) {
                continue;
            }
            $maze = $this->moveBot($maze, $botInstructions[$i], $botX, $botY);
            $this->printMaze($maze);
            usleep(1_000_000);
        }
    }

    function getBotPosition(array $maze): array
    {
        foreach ($maze as $y => $line) {
            if (in_array('@', $line, true)) {
                return [array_search('@', $line, true), $y];
            }
        }

        $this->log('cant find the bot! :(');
        exit(1);
    }

    function botCanMove(array $maze, string $direction, int $botX, int $botY): bool
    {
        $this->debug(sprintf('bot is at position %d,%d and wants to move %s', $botX, $botY, $direction));
        switch ($direction) {
            case '<':
                //bot wants to move left. are there any free spaces to the left of it?
                $line = $maze[$botY];
                $botCanMove = in_array('.', array_slice($line, 0, $botX), true);
                break;
            case '>':
                //move right
                $line = $maze[$botY];
                $botCanMove = in_array('.', array_slice($line, $botX), true);
                break;
            case 'v':
                $line = array_column($maze, $botX);
                $botCanMove = in_array('.', array_slice($line, $botY), true);
                break;
            case '^':
                $line = array_column($maze, $botX);
                $botCanMove = in_array('.', array_slice($line, 0, $botY), true);
                break;
            default:
                die('wtf?' . $direction);
        }
        $this->debug($botCanMove ? 'bot can move!' : 'bot can NOT move!');

        return $botCanMove;
    }

    function moveBot(array $maze, string $direction, int $botX, int $botY): array
    {
        //move bot in given direction, and loop through everything that is
        //directly in its path, one space over, until an empty spot is found.
        //if a wall is found, something went wrong in botCanMove() earlier.
        $mazeWidth = count($maze[0]);
        $mazeHeight = count($maze);
        $lastChar = '@';
        switch ($direction) {
            case '<':
                print 'moving bot left' . PHP_EOL;
                $maze[$botX][$botY] = '.';
                for ($i = $botX - 1; $i > 0; $i--) {
                    if ($maze[$botY][$i] !== '.') {
                        //move last character over one place, remember what we removed
                        $backup = $maze[$botY][$i];
                        $maze[$botY][$i] = $lastChar;
                        $lastChar = $backup;
                    } else {
                        //next character is a period, so we're done!
                        $maze[$botY][$i] = $lastChar;
                        $maze[$botY][$botX] = '.';
                        break;
                    }
                }
                break;
            case '>':
                $this->debug('moving bot right');
                for ($i = $botX + 1; $i < $mazeWidth; $i++) {

                }
                break;
            case 'v':
                $this->debug('moving bot down');
                for ($i = $botY + 1; $i < $mazeHeight; $i++) {

                }
                break;
            case '^':
                $this->debug('moving bot up');
                for ($i = $botY - 1; $i > 0; $i--) {

                }
                break;
        }

        return $maze;
    }

    function printMaze(array $maze): void
    {
        //print maze with fancy colors and in-place editing?
        foreach ($maze as $row) {
            print implode('', $row) . PHP_EOL;
        }
    }
}

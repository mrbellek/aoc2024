<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day14 extends AbstractDay
{
    private array $bots;
    private int $sampleRoomSizeX = 11;
    private int $sampleRoomSizeY = 7;
    private int $roomSizeX = 101;
    private int $roomSizeY = 103;

    public function part1(): void
    {
        $seconds = 100;
        $this->parseBots();
        $this->moveBots($seconds);
        $this->log(sprintf('Bots finished moving for %d seconds at once.', $seconds));
        $this->printBots();
        $safety = $this->calcSafetyFactor();
        $this->log(sprintf('The resulting safety factor is: %f', $safety));
    }

    private function calcSafetyFactor(): float
    {
        $quadCount1 = $quadCount2 = $quadCount3 = $quadCount4 = 0;

        $roomSizeX = $this->isLive ? $this->roomSizeX : $this->sampleRoomSizeX;
        $roomSizeY = $this->isLive ? $this->roomSizeY : $this->sampleRoomSizeY;
        $q1Range = [
            'xmin' => 0,
            'xmax' => floor($roomSizeX / 2),
            'ymin' => 0,
            'ymax' => floor($roomSizeY / 2),
        ];
        $q2Range = [
            'xmin' => ceil($roomSizeX / 2) + 1,
            'xmax' => $roomSizeX,
            'ymin' => 0,
            'ymax' => floor($roomSizeY / 2),
        ];
        $q3Range = [
            'xmin' => 0,
            'xmax' => floor($roomSizeX / 2),
            'ymin' => ceil($roomSizeY / 2) + 1,
            'ymax' => $roomSizeY,
        ];
        $q4Range = [
            'xmin' => ceil($roomSizeX / 2) + 1,
            'xmax' => $roomSizeX,
            'ymin' => ceil($roomSizeY / 2) + 1,
            'ymax' => $roomSizeY,
        ];

        foreach ($this->bots as $bot) {
            if ($bot['x'] >= $q1Range['xmin'] && $bot['x'] <= $q1Range['xmax'] && $bot['y'] >= $q1Range['ymin'] && $bot['y'] <= $q1Range['ymax']) {
                $this->debug(sprintf('bot at [%d,%d] falls in Q1!', $bot['x'], $bot['y']));
                $quadCount1++;
            } elseif ($bot['x'] >= $q2Range['xmin'] && $bot['x'] <= $q2Range['xmax'] && $bot['y'] >= $q2Range['ymin'] && $bot['y'] <= $q2Range['ymax']) {
                $this->debug(sprintf('bot at [%d,%d] falls in Q2!', $bot['x'], $bot['y']));
                $quadCount2++;
            } elseif ($bot['x'] >= $q3Range['xmin'] && $bot['x'] <= $q3Range['xmax'] && $bot['y'] >= $q3Range['ymin'] && $bot['y'] <= $q3Range['ymax']) {
                $this->debug(sprintf('bot at [%d,%d] falls in Q3!', $bot['x'], $bot['y']));
                $quadCount3++;
            } elseif ($bot['x'] >= $q4Range['xmin'] && $bot['x'] <= $q4Range['xmax'] && $bot['y'] >= $q4Range['ymin'] && $bot['y'] <= $q4Range['ymax']) {
                $this->debug(sprintf('bot at [%d,%d] falls in Q4!', $bot['x'], $bot['y']));
                $quadCount4++;
            } else {
                //bot falls in middle line horizontally or vertically
            }
        }

        $this->debug(sprintf('Quadrant counts: %d %d %d %d', $quadCount1, $quadCount2, $quadCount3, $quadCount4));
        return $quadCount1 * $quadCount2 * $quadCount3 * $quadCount4;
    }
    
    private function moveBots(int $seconds = 1): void
    {
        $roomSizeX = $this->isLive ? $this->roomSizeX : $this->sampleRoomSizeX;
        $roomSizeY = $this->isLive ? $this->roomSizeY : $this->sampleRoomSizeY;
        foreach ($this->bots as $i => $bot) {
            $this->debug(sprintf(
                'bot %d was on %d,%x and moves to %d,%d',
                $i,
                $bot['x'],
                $bot['y'],
                $bot['x'] + $bot['vx'],
                $bot['y'] + $bot['vy'],
            ));
            $this->bots[$i]['x'] += $seconds * $bot['vx'];
            $this->bots[$i]['x'] %= $roomSizeX;
            $this->bots[$i]['y'] += $seconds * $bot['vy'];
            $this->bots[$i]['y'] %= $roomSizeY;
            if ($this->bots[$i]['x'] < 0) {
                $this->bots[$i]['x'] += $roomSizeX;
            }
            if ($this->bots[$i]['y'] < 0) {
                $this->bots[$i]['y'] += $roomSizeY;
            }
        }
    }

    private function printBots(): void
    {
        $matrix = [];
        if ($this->isLive) {
            for ($i = 0; $i < $this->roomSizeY; $i++) {
                $matrix[] = str_split(str_repeat('.', $this->roomSizeX));
            }
        } else {
            for ($i = 0; $i < $this->sampleRoomSizeY; $i++) {
                $matrix[] = str_split(str_repeat('.', $this->sampleRoomSizeX));
            }
        }

        foreach ($this->bots as $bot) {
            $x = $bot['x'];
            $y = $bot['y'];
            if ($matrix[$y][$x] === '.') {
                $matrix[$y][$x] = '1';
            } else {
                $matrix[$y][$x]++;
            }
        }

        foreach ($matrix as $line) {
            print(implode('', $line) . PHP_EOL);
        }
        echo PHP_EOL;
    }

    private function parseBots(): void
    {
        $this->bots = [];
        foreach ($this->input as $line) {
            if (preg_match('/p=(\d+),(\d+) v=([\d-]+),([\d-]+)/', $line, $m) === 1) {
                $this->bots[] = [
                    'x' => $m[1],
                    'y' => $m[2],
                    'vx' => $m[3],
                    'vy' => $m[4],
                ];
            } else {
                die('wtf?');
            }
        }
    }
}

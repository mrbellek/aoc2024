<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day06 extends AbstractDay
{
    public const PART1_COMPLETE = false;

    private array $matrix;
    private const MATRIX_WIDTH = 1000;
    private const MATRIX_HEIGHT = 1000;

    public function part1(): void
    {
        //create matrix of lights
        for ($i = 0; $i < self::MATRIX_HEIGHT; $i++) {
            $this->matrix[$i] = array_fill(0, self::MATRIX_WIDTH, '0');
        }

        //parse and execute instructions
        foreach ($this->input as $instructRaw) {
            $instruct = $this->parse($instructRaw);
            $this->execute($instruct);

            if (!$this->isLive) {
        $this->debug(sprintf('%s: %d lights are lit', $instructRaw, $this->countLit()));
            }
        }

        $this->log(sprintf('%d lights are turned on!', $this->countLit()));
    }

    private function parse($line): array
    {
        $m = [];
        if (preg_match('/(turn on|turn off|toggle) (\d+),(\d+) through (\d+),(\d+)/', $line, $m) === 1) {

            return [
                'action' => $m[1],
                'start' => ['x' => $m[2], 'y' => $m[3]],
                'end' => ['x' => $m[4], 'y' => $m[5]],
                'width' => $m[4] - $m[2] + 1,
                'height' => $m[5] - $m[3] + 1,
            ];
        } else {
            $this->log(sprintf('failed to parse line: %s', $line));
        }
    }

    private function execute(array $instruct): void
    {
        for ($y = $instruct['start']['y']; $y <= $instruct['end']['y']; $y++) {
            $x = $instruct['start']['x'];
            $length = $instruct['width'];
            switch ($instruct['action']) {
                case 'turn on':
                    array_splice($this->matrix[$y], intval($x), $length, array_fill(0, $length, '1'));
                    break;
                case 'turn off':
                    array_splice($this->matrix[$y], intval($x), $length, array_fill(0, $length, '0'));
                    break;
                case 'toggle':
                    for ($i = $x; $i < $length; $i++) {
                        $this->matrix[$y][$i] = $this->matrix[$y][$i] ? '0' : '1';
                    }
                    break;
                default:
                    $this->log(sprintf('invalid action "%s"', $instruct['action']));
                    exit(1);
            }
        }
    }

    private function countLit(): int
    {
        $sum = 0;
        foreach ($this->matrix as $row) {
            $sum += array_sum($row);
        }

        return intval($sum);
    }
}
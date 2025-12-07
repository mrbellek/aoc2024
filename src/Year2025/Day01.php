<?php

declare(strict_types=1);

namespace AdventOfCode\Year2025;

use AdventOfCode\AbstractDay;
use InvalidArgumentException;

class Day01 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = false;

    private int $position = 50;

    public function part1(): void
    {
        $zeroPositions = 0;
        foreach ($this->input as $action) {
            $this->rotate($action);

            if ($this->position === 0) {
                $zeroPositions++;
            }

        }

        $this->log(sprintf('Total amount of times position was zero after %d actions: %d', count($this->input), $zeroPositions));
    }

    public function part2(): void
    {
        $zeroPositions = 0;
        foreach ($this->input as $action) {
            $zeroPositions += $this->rotateAndCountZeroPasses($action);
        }

        $this->log(sprintf('Total amount of times dial has passed zero after %d action: %d', count($this->input), $zeroPositions));
    }

    private function rotate(string $action): void
    {
        $direction = $action[0];
        $amount = (int)substr($action, 1);

        if ($direction === 'L') {
            $this->position -= $amount;
            while ($this->position < 0) {
                $this->position += 100;
            }
        } elseif ($direction === 'R') {
            $this->position += $amount;
            while ($this->position >= 100) {
                $this->position -= 100;
            }
        } else {
            throw new InvalidArgumentException('Invalid input: "' . $action . '"');
        }

        $this->log(sprintf('Rotated the lock %s %d spaces to position %d', $direction, $amount, $this->position));
    }

    /**
     * This is wrong and I don't understand why
     */
    private function rotateAndCountZeroPasses(string $action): int
    {
        $direction = $action[0];
        $amount = (int)substr($action, 1);
        $zeroPasses = 0;

        for ($i = 0; $i < $amount; $i++) {
            if ($direction === 'L') {
                $this->position--;
                if ($this->position < 0) {
                    $this->position = 99;
                }
            } elseif ($direction === 'R') {
                $this->position++;
                if ($this->position >= 100) {
                    $this->position = 0;
                }
            }

            if ($this->position === 0) {
                $zeroPasses++;
            }
        }

        $this->debug(sprintf('Rotated the lock %s %d spaces to position %d, passed zero %d times', $direction, $amount, $this->position, $zeroPasses));

        return $zeroPasses;
    }
}
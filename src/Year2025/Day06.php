<?php

declare(strict_types=1);

namespace AdventOfCode\Year2025;

use AdventOfCode\AbstractDay;
use InvalidArgumentException;

class Day06 extends AbstractDay
{
    private array $matrix = [];

    public function part1(): void
    {
        $this->loadMatrix();

        $grandTotal = 0;
        $problemCount = count($this->matrix[0]);
        for ($i = 0; $i < $problemCount; $i++) {
            $problem = array_column($this->matrix, $i);
            $answer = $this->solveProblem($problem);
            $this->debug(sprintf('Answer to problem %d was: %s', $i, $answer));
            $grandTotal += $answer;
        }

        $this->log('Grand total: ' . $grandTotal);
    }

    private function solveProblem(array $problem): float
    {
        return match (array_pop($problem)) {
            '+' => array_sum($problem),
            '*' => array_product($problem),
            default => throw new InvalidArgumentException('invalid operand'),
        };
    }

    private function loadMatrix(): void
    {
        foreach ($this->input as $line) {
            $this->matrix[] = preg_split('/\s+/', trim($line));
        }
    }
}
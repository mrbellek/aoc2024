<?php

declare(strict_types=1);

namespace AdventOfCode\Year2025;

use AdventOfCode\AbstractDay;
use InvalidArgumentException;

class Day06 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

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

    public function part2(): void
    {
        $this->loadMatrixWithWhitespace();
        $problems = $this->parseProblems();

        $grandTotal = 0;
        foreach ($problems as $i => $problem) {
            $answer = $this->solveProblem($problem);
            $this->debug(sprintf('Answer to problem %d was: %s', $i, $answer));
            $grandTotal += $answer;
        }

        $this->log('Grand total part 2: ' . $grandTotal);
    }

    private function parseProblems(): array
    {
        $columnCount = count($this->matrix[0]);
        $problems = [];
        $problemIndex = 0;
        for ($i = $columnCount; $i >= 0; $i--) {
            //loop through columns, right-to-left
            $column = array_column($this->matrix, $i);
            if (trim(implode('', $column)) === '') {
                //column was only spaces, so end of problem
                $problemIndex++;
            } else {
                $operand = end($column);
                if (in_array($operand, ['*', '+'], true)) {
                    //if column ends with operand, split it off from the number
                    $problems[$problemIndex][] = trim(implode('', array_slice($column, 0, -1)));
                    $problems[$problemIndex][] = $operand;
                } else {
                    $problems[$problemIndex][] = trim(implode('', $column));
                }
            }
        }

        return $problems;
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

    private function loadMatrixWithWhitespace(): void
    {
        foreach ($this->input as $line) {
            $this->matrix[] = str_split($line);
        }
    }
}
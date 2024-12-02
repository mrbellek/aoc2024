<?php

declare(strict_types=1);

//advent of code 2024 - day 2

class Day02
{
    private array $input;

    public function __construct()
    {
        $this->input = file('input02.txt', FILE_IGNORE_NEW_LINES);
        //$this->input = file('sample02.txt', FILE_IGNORE_NEW_LINES);
    }

    public function part1(): void
    {
        $safeCount = 0;
        foreach ($this->input as $report) {
            if ($this->isReportSafe(explode(' ', $report))) {
                $safeCount++;
            }
        }

        printf('There were %d safe reports in %d total.' . PHP_EOL, $safeCount, count($this->input));
    }

    private function isReportSafe(array $report): bool
    {
        $changes = [];
        $count   = count($report);
        for ($i = 1; $i < $count; $i++) {
            $changes[$i] = $report[$i - 1] - $report[$i];
        }

        if (max($changes) > 3 || min($changes) < -3) {
            //values must not increase/decrease by more than 3
            return false;
        }

        if (in_array(0, $changes, true)) {
            //values must increase/decrease by at least 1
            return false;
        }

        if ($this->allPositiveOrAllNegative($changes) === false) {
            //values must either all increase or all decrease
            return false;
        }

        return true;
    }

    private function allPositiveOrAllNegative(array $changes): bool
    {
        $neg = array_filter($changes, static fn(int $num) => $num < 0);
        $pos = array_filter($changes, static fn(int $num) => $num > 0);

        return count($neg) === count($changes) || count($pos) === count($changes);
    }
}

(new Day02())->part1();
//(new Day02())->part2();

<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day02 extends AbstractDay
{
    public function part1(): void
    {
        $safeCount = 0;
        foreach ($this->input as $report) {
            if ($this->isReportSafe(explode(' ', $report))) {
                $safeCount++;
            }
        }

        $this->log(sprintf('There were %d safe reports in %d total.', $safeCount, count($this->input)));
    }

    public function part2(): void
    {
        $safeCount = 0;
        foreach ($this->input as $report) {
            if ($this->isReportSafe(explode(' ', $report))) {
                echo '.';
                $safeCount++;
            } elseif ($this->isReportSafeWithDampener(explode(' ', $report))) {
                echo '!';
                $safeCount++;
            }
        }
        echo PHP_EOL;

        $this->log(sprintf(
            'There were %d safe (with dampener) reports in %d total.',
            $safeCount,
            count($this->input)
        ));
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

    private function isReportSafeWithDampener(array $report): bool
    {
        $extraReports = [];
        $count = count($report); //NB: sample has all rows of 5 items, actual input varies from 5 to 8 entries!

        //add all reports with one number removed
        for ($i = 0; $i < $count; $i++) {
            $extraReport = $report;
            unset($extraReport[$i]);
            $extraReports[] = array_values($extraReport);
        }
        foreach ($extraReports as $extraReport) {
            if ($this->isReportSafe($extraReport)) {
                return true;
            }
        }

        return false;
    }

    private function allPositiveOrAllNegative(array $changes): bool
    {
        $neg = array_filter($changes, static fn(int $num) => $num < 0);
        $pos = array_filter($changes, static fn(int $num) => $num > 0);

        return count($neg) === count($changes) || count($pos) === count($changes);
    }
}

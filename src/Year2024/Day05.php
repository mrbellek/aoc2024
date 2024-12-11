<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day05 extends AbstractDay
{
    private array $orderRules = [];
    private array $pageLines = [];

    public function part1(): void
    {
        $this->extractRulesAndLines();

        $validLines = array_filter($this->pageLines, fn (array $line) => $this->isValidLine($line));

        $pageNumerSum = 0;
        foreach ($validLines as $line) {
            if (count($line) % 2 === 1) {
                $this->debug(sprintf('Valid line: %s', implode(',', $line)));
                $pageNumerSum += $line[floor(count($line) / 2)];
            } else {
                //does not happen
            }
        }

        $this->log(sprintf('The sum of the middle page numbers of valid lines is: %d', $pageNumerSum));
    }

    private function extractRulesAndLines(): void
    {
        $secondPart = false;
        foreach ($this->input as $line) {
            if (trim($line) === '') {
                $secondPart = true;
                continue;
            }

            if ($secondPart === false) {
                [$firstPage, $secondPage] = explode('|', $line);
                $this->orderRules[$firstPage][] = $secondPage;
            } else {
                $this->pageLines[] = explode(',', $line);
            }
        }
    }

    private function isValidLine(array $line): bool
    {
        foreach ($line as $i => $number) {
            if (!isset($line[$i+1])) {
                break;
            }

            ///check all following numbers against rules
            foreach (array_slice($line, $i+1) as $nextNumber) {
                $this->debug(sprintf('checking if %d shouldbe followed by %d', $number, $nextNumber));

                if (array_key_exists($nextNumber, $this->orderRules) && in_array($number, $this->orderRules[$nextNumber])) {
                    return false;
                }
                if (!array_key_exists($number, $this->orderRules) || !array_key_exists($nextNumber, $this->orderRules[$number])) {
                    continue;
                }
                if (!in_array($nextNumber, $this->orderRules[$number])) {
                    return false;
                }
            }
        }
        
        return true;
    }

    public function part2(): void
    {
        $this->extractRulesAndLines();

        $invalidLines = array_filter($this->pageLines, fn (array $line) => !$this->isValidLine($line));
        $sortedLines = [];
        foreach ($invalidLines as $line) {
            $sortedLines[] = $this->sortByOrderRules($line);
        }

        $pageNumberSum = 0;
        foreach ($sortedLines as $line) {
            $pageNumberSum += $line[floor(count($line) / 2)];
        }

        $this->log(sprintf('oplossing is %d', $pageNumberSum));
    }

    private function sortByOrderRules(array $line): array
    {
        usort($line, function ($a, $b) {
            if (!array_key_exists($a, $this->orderRules)) {
                return 0;
            } elseif (
                in_array($b, $this->orderRules[$a] ?? []) &&
                !in_array($a, $this->orderRules[$b] ?? [])
            ) {
                return 1;
            } else {
                return -1;
            }
        });

        return $line;
    }
}

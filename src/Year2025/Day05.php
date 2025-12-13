<?php

declare(strict_types=1);

namespace AdventOfCode\Year2025;

use AdventOfCode\AbstractDay;
use AdventOfCode\Helpers\InputHelper;
use AdventOfCode\Helpers\Logger;

class Day05 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = false;

    private array $ranges = [];
    private array $ingredients = [];

    public function __construct(
        InputHelper $inputHelper,
        private readonly Logger $logger,
        string $dataSet,
    ) {
        parent::__construct($inputHelper, $logger, $dataSet);

        //for some dumb reason the live input uses a different line ending
        define('EOL', $this->isLive ? "\n" : PHP_EOL);
    }

    public function part1(): void
    {
        $this->parseInput();

        $fresh = 0;
        foreach ($this->ingredients as $ingredientId) {
            $fresh = $fresh + (int)$this->isFresh((int)$ingredientId);
        }

        $this->log(sprintf(
            '%d out of %d ingredients are fresh',
            $fresh,
            count($this->ingredients)
        ));
    }

    public function part2(): void
    {
        $this->parseInput();
        $allNumbers = [];
        foreach ($this->ranges as $range) {
            for ($i = $range['from']; $i <= $range['to']; $i++) {
                $allNumbers[$i] = 1;
            }
        }

        //does not work on live data - out of memory
        $this->log(sprintf('Total ingredient count: %d', count($allNumbers)));

        /*foreach ($this->ranges as $i => $range1) {
            foreach ($this->ranges as $j => $range2) {
                if ($i === $j) {
                    continue;
                }
                if (
                    ($range1['to'] >= $range2['from'] && $range1['from'] < $range2['to']) ||
                    ($range1['from'] <= $range2['to'] && $range1['to'] > $range2['from'])
                ) {
                    $this->log(sprintf('Ranges %d-%d overlaps with %d-%d', 
                        $range1['from'],
                        $range1['to'],
                        $range2['from'],
                        $range2['to'],
                    ));
                }
            }
        }
        $this->log('Finished looking for overlaps');*/
    }

    private function isFresh(int $ingredientId): bool
    {
        foreach ($this->ranges as $range) {
            if ($ingredientId >= $range['from'] && $ingredientId <= $range['to']) {
                $this->debug(sprintf('Id %d is fresh, within range %d-%d',
                    $ingredientId,
                    $range['from'],
                    $range['to']
                ));
                return true;
            }
        }

        $this->debug(sprintf('Id %d is spoiled', $ingredientId));

        return false;
    }

    private function parseInput(): void
    {
        [$rangesStr, $ingredientsStr] = explode(EOL . EOL, $this->inputStr);
        $ranges = explode(EOL, $rangesStr);
        $ingredients = explode(EOL, $ingredientsStr);

        foreach ($ranges as $range) {
            [$from, $to] = explode('-', $range);
            $this->ranges[] = ['from' => $from, 'to' => $to];
        }

        $this->ingredients = $ingredients;
    }
}

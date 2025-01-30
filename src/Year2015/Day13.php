<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;
use AdventOfCode\Traits\PermutationTrait;

class Day13 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    use PermutationTrait;

    private array $happiness = [];

    public function part1(): void
    {
        $this->parseHappiness();
        $maxHappiness = 0;
        $maxHappinessSeating = [];
        foreach ($this->getPermutations(array_keys($this->happiness)) as $seating) {
            $happiness = $this->getSeatingHappiness($seating);
            if ($happiness > $maxHappiness) {
                $maxHappiness = $happiness;
                $maxHappinessSeating = $seating;
            }
        }

        $this->log(sprintf('The maximum happiness is %d with seating %s',
            $maxHappiness,
            implode(',', $maxHappinessSeating)
        ));
    }

    public function part2(): void
    {
        $this->parseHappiness();
        $this->happiness['mrbellek'] = [
            'Alice' => 0,
            'Bob' => 0,
            'Carol' => 0,
            'David' => 0,
            'Eric' => 0,
            'Frank' => 0,
            'George' => 0,
            'Mallory' => 0,
        ];

        $maxHappiness = 0;
        $maxHappinessSeating = [];
        foreach ($this->getPermutations(array_keys($this->happiness)) as $seating) {
            $happiness = $this->getSeatingHappiness($seating);
            if ($happiness > $maxHappiness) {
                $maxHappiness = $happiness;
                $maxHappinessSeating = $seating;
            }
        }

        $this->log(sprintf('The maximum happiness is %d with seating %s',
            $maxHappiness,
            implode(',', $maxHappinessSeating)
        ));
    }

    private function parseHappiness(): void
    {
        foreach ($this->input as $line) {
            if (preg_match('/^(\w+) .+ (gain|lose) (\d+) .* (\w+).$/', $line, $m) === 1) {
                $this->happiness[$m[1]][$m[4]] = ($m[2] === 'lose' ? $m[3] * -1 : $m[3]);
            } else {
                die('wtf?');
            }
        }
    }

    private function getSeatingHappiness(array $seating): int
    {
        $happiness = 0;
        foreach ($seating as $i => $name) {
            //get happiness due to left neighbour
            $leftNeighbour = $seating[$i - 1] ?? $seating[count($seating) - 1];
            $leftHappiness = $this->happiness[$name][$leftNeighbour] ?? 0;

            //get happiness due to right neighbour
            $rightNeighbour = $seating[$i + 1] ?? $seating[0];
            $rightHappiness = $this->happiness[$name][$rightNeighbour] ?? 0;

            $happiness += $leftHappiness + $rightHappiness;
        }

        $this->debug(sprintf(
            'The seating %s has total happiness %d',
            implode(',', $seating),
            $happiness
        ));

        return $happiness;
    }
}

<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;
use AdventOfCode\Traits\PermutationTrait;

class Day13 extends AbstractDay
{
    use PermutationTrait;

    private $happiness = [];

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
            $happiness += $leftHappiness + $rightHappiness;
        }

        return $happiness;
    }
}

<?php

declare(strict_types=1);

namespace AdventOfCode\Year2025;

use AdventOfCode\AbstractDay;
use AdventOfCode\Traits\PermutationTrait;
use InvalidArgumentException;

class Day10 extends AbstractDay
{
    use PermutationTrait;

    public const PART1_COMPLETE = false;
    public const PART2_COMPLETE = false;

    private $machines = [];
    
    public function part1(): void
    {
        $this->parseInput();

        /**
         * TODO:
         * - loop through all possible iterations of all buttons
         * - repeating buttons are possible, infinitely but within reason
         * - if a resulting state is identical to an earlier one, it's a dead end
         * 
         * maybe use this lib? BaseMax/YourCombinationsPHP
         */
        $i = 0;
        foreach ($this->machines as $machine) {
            $elements = $machine['buttons'];
            //this only yields combinations of all elements, one each
            foreach ($this->getPermutations($elements) as $permutation) {
                echo implode(' ', $permutation) . PHP_EOL;
                $i++;
                if ($i > 5) exit();
            }
        }
    }

    private function parseInput(): void
    {
        $matches = [];
        $regex = '/^\[([#.]+)] ([(\d+, )]+)\{([\d,]+)/';
        foreach ($this->input as $machineRaw) {
            if (preg_match($regex, $machineRaw, $matches) === 1) {
                $this->machines[] = [
                    'display' => $matches[1],
                    'buttons' => explode(' ', trim($matches[2])),
                    'joltages' => $matches[3],
                ];
            } else {
                throw new InvalidArgumentException('invalid: ' . $machineRaw);
            }
        }
    }
}

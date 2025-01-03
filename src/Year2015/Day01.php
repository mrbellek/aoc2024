<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day01 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    public function part1(): void
    {
        $instruct = $this->input[0];

        $upCount = substr_count($instruct, '(');
        $downCount = substr_count($instruct, ')');
        $this->log(sprintf(
            'Input %s puts Santa on floor %d.',
            strlen($instruct) > 20 ? substr($instruct, 0, 20) . '...' : $instruct,
            $upCount - $downCount
        ));
    }

    public function part2(): void
    {
        $input = $this->input[0];

        $currentFloor = 0;
        $basementTrigger = null;
        for ($i = 0; $i < strlen($input); $i++) {
            if (substr($input, $i, 1) === '(') {
                $currentFloor++;
            } elseif (substr($input, $i, 1) === ')') {
                $currentFloor--;
            }
            
            if ($currentFloor < 0 && $basementTrigger === null) {
                $basementTrigger = $i;
            }
        }

        if ($basementTrigger === null) {
            $this->log(sprintf('Final floor is %d, but Santa did not go into the basement', $currentFloor));
        } else {
            $this->log(sprintf('Final floor is %d, and Santa went into the basement first at instruct %d', $currentFloor, $basementTrigger + 1));
        }
    }
}
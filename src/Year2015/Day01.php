<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day01 extends AbstractDay
{
    public function part1(): void
    {
        $instruct = $this->input[0];

        $upCount = substr_count($instruct, '(');
        $downCount = substr_count($instruct, ')');
        printf(
            'Input %s puts Santa on floor %d.' . PHP_EOL,
            strlen($instruct) > 20 ? substr($instruct, 0, 20) . '...' : $instruct,
            $upCount - $downCount
        );
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

        printf('Final floor is %d, and Santa went into the basement first at instruct %d' . PHP_EOL, $currentFloor, $basementTrigger+1);
    }
}
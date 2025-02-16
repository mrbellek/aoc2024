<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;
use AdventOfCode\Traits\PermutationTrait;

class Day19 extends AbstractDay
{
    public function part1(): void
    {
        $startMol = end($this->input);
        $this->input = array_slice($this->input, 0, -2);
        $this->dd($startMol, $this->input);
    }
}

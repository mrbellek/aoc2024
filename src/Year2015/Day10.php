<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day10 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    public function part1(): void
    {
        if ($this->isLive) {
            $amount = 40;
        } else {
            $amount = 5;
        }
        $result = $this->lookAndSay($this->input[0], $amount);
        $this->log(sprintf('Look-and-say x%d turns %s into a string of length %d',
            $amount,
            $this->input[0],
            strlen($result)
        ));
    }

    public function part2(): void
    {
        if ($this->isLive) {
            ini_set('memory_limit', '1G');
            $amount = 50;
            $result = $this->lookAndSay($this->input[0], $amount);
        } else {
            $this->fatal('theres no part2 for the sample input');
        }
        $this->log(sprintf('Look-and-say x%d turns %s into a string of length %d',
            $amount,
            $this->input[0],
            strlen($result)
        ));
    }

    private function lookAndSay(string $input, int $times): string
    {
        $m = [];
        if (preg_match_all('/(.)(\1*)/', $input, $m) > 0) {
            $groups = $m[0];
        } else {
            $this->fatal(sprintf('string "%s" doesnt look like a sequence of numbers', $input));
        }

        $output = '';
        foreach ($groups as $group) {
            $output .= strval(strlen($group)) . substr($group, 0, 1);
        }
        $this->debug(sprintf('%s -> %s', $input, $output));

        if ($times === 1) {
            return $output;
        } else {
            return $this->lookAndSay($output, $times - 1);
        }
    }
}

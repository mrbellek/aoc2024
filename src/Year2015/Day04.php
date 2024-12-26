<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day04 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    public function part1(): void
    {
        $input = $this->input[0];
        if ($this->checkHasMD5With($input, '00000')) {
            $this->log(sprintf('Input by itself is a hit!'));
        }
        for ($i = 1; $i < 1_000_000; $i++) {
            if ($this->checkHasMD5With($input . $i, '00000')) {
                $this->log(sprintf('Input + %d is a hit!', $i));
                break;
            }
        }
    }

    public function part2(): void
    {
        $input = $this->input[0];
        if ($this->checkHasMD5With($input, '000000')) {
            $this->log(sprintf('Input by itself is a hit!'));
        }
        for ($i = 1; $i < 10_000_000; $i++) {
            if ($this->checkHasMD5With($input . $i, '000000')) {
                $this->log(sprintf('Input + %d is a hit!', $i));
                break;
            }
        }
    }

    private function checkHasMD5With(string $input, string $startsWith): bool
    {
        $md5 = md5($input);
        if (str_starts_with($md5, $startsWith)) {
            $this->debug($md5);
            return true;
        }

        return false;
    }
}

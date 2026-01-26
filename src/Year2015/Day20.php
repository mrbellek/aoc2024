<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day20 extends AbstractDay
{
    public function part1(): void
    {
        if ($this->isLive === false) {
            $this->printExample();
        }

        $targetPresents = $this->input[0];
        $maxHouse = 500000;
        for ($i = 10; $i <= $maxHouse; $i += 10000) {
            $presents = $this->getHousePresents($i);
            if ($presents >= $targetPresents) {
                $this->log(sprintf(
                    'House %d gets %d presents.',
                    $i,
                    $targetPresents
                ));
                exit(0);
            }
        }

        $this->log(sprintf('Didnt find target present count %d before house %d, which got %d presents', $targetPresents, $maxHouse, $presents));
    }

    private function printExample(): void
    {
        for ($i = 1; $i < 10; $i++) {
            $this->debug(sprintf(
                'House %d receives %d presents',
                $i,
                $this->getHousePresents($i)
            ));
        }
    }

    private function getHousePresents(int $i): int
    {
        $presents = 0;
        $elf = 1;
        while ($elf <= $i) {
            if ($i % $elf === 0) {
                //elf delivers to this house, e.g. elf 2 delivers to house 4
                $presents += $elf * 10;
            }
            $elf++;
        }

        return $presents;
    }
}

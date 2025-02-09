<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;
use AdventOfCode\Traits\PermutationTrait;

class Day17 extends AbstractDay
{
    use PermutationTrait;

    private array $containers;
    private int $eggnogVolume = 150;

    public function part1(): void
    {
        if ($this->isLive === false) {
            $this->eggnogVolume = 25;
        }

        foreach (array_filter($this->input) as $i => $volume) {
            $this->containers[$i] = ['index' => $i, 'volume' => $volume];
        }

        $containerSets = [];
        foreach ($this->getPermutations($this->containers) as $containers) {
            $num = $this->fitsNumContainersExactly($containers);
            if ($num > 0) {
                $containerSet = array_slice($containers, 0, $num, true);
                sort($containerSet);
                $containerSets[] = $containerSet;
            }
        }

        $containerSets = array_unique($containerSets);
        $this->log(sprintf('There are %d combinations of the given containers that fit %d L eggnog',
            count($containerSets),
            $this->eggnogVolume
        ));
        foreach ($containerSets as $containerSet) {
            $this->debug($containerSet);
        }
    }

    private function fitsNumContainersExactly(array $containers): int
    {
        $remainingVolume = $this->eggnogVolume;
        $numContainers = 0;
        foreach ($containers as $container) {
            $remainingVolume -= (int)$container['volume'];
            $numContainers++;
            if ($remainingVolume === 0) {
                return $numContainers;
            } elseif ($remainingVolume < 0) {
                return 0;
            }
        }

        return 0;
    }
}

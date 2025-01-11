<?php

declare(strict_types=1);

namespace AdventOfCode\Traits;

use Generator;

trait PermutationTrait
{
    //recursively calculate all possible permutations of the elements in a given array
    //usage: foreach (getPermutations($array) as $permutation) { ... }
    private function getPermutations(array $elements): Generator
    {
        if (count($elements) <= 1) {
            yield $elements;
        } else {
            foreach ($this->getPermutations(array_slice($elements, 1)) as $permutation) {
                foreach (range(0, count($elements) - 1) as $i) {
                    yield array_merge(
                        array_slice($permutation, 0, $i),
                        [$elements[0]],
                        array_slice($permutation, $i)
                    );
                }
            }
        }
    }
}

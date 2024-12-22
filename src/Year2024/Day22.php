<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day22 extends AbstractDay
{
    public const PART1_COMPLETE = true;

    public function part1(): void
    {
        /*$secret = 123;
        for ($i = 0; $i < 10; $i++) {
            $secret = $this->getNextSecret($secret);
            $this->debug(sprintf('Next secret: %d', $secret));
        }
        exit();*/

        $totalSecrets = 0;
        foreach ($this->input as $initSecret) {
            $secret = intval($initSecret);
            for ($i = 0; $i < 2000; $i++) {
                $secret = $this->getNextSecret($secret);
            }
            $totalSecrets += $secret;
            $this->debug(sprintf('%d: %d', $initSecret, $secret));
        }
        $this->log(sprintf('Final sum of 2000th secrets: %d', $totalSecrets));
    }

    private function getNextSecret(int $secret): int
    {
        $secret1 = $this->mixAndPrune($secret, $secret * 64);
        $secret2 = $this->mixAndPrune($secret1, intval(floor($secret1 / 32)));
        $secret3 = $this->mixAndPrune($secret2, $secret2 * 2048);

        return $secret3;
    }

    private function mixAndPrune(int $secret, int $value): int
    {
        return ($secret ^ $value) % 16777216;
    }
}

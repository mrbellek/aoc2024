<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day19 extends AbstractDay
{
    private array $replacements;

    public function part1(): void
    {
        //last line of input is starting molecule, separated from the replacements by a blank line
        $startMol = end($this->input);
        $this->parseInput(array_slice($this->input, 0, -2));
        $molecules = $this->runReplacements($startMol);
        $this->log(sprintf(
            'Found %d distinct molecules',
            count($molecules)
        ));
        if ($this->isLive === false) {
            print_r($molecules);
        }
    }

    private function parseInput(array $input): void
    {
        foreach ($input as $line) {
            if (preg_match('/^(\w+) => (\w+)$/', $line, $m) === 1) {
                $this->replacements[] = [
                    'from' => $m[1],
                    'to' => $m[2],
                ];
            } else {
                die('wtf?');
            }
        }
    }

    private function runReplacements(string $startMol): array
    {
        $results = [];
        foreach ($this->replacements as $replacement) {
            for ($i = 0; $i < strlen($startMol); $i++) {
                //convert molecule from string to array, or php will only
                //replace the first byte of the result
                //@TODO this doesnt account for 'from' entries that are longer than one character!
                $result = str_split($startMol);
                $result[$i] = str_replace($replacement['from'], $replacement['to'], $startMol[$i]);
                if (implode('', $result) !== $startMol) {
                    $results[] = implode('', $result);
                }
            }
        }

        $this->log(sprintf('%d nonunique results', count($results)));
        return array_unique($results);
    }
}

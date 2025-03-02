<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day19 extends AbstractDay
{
    public const PART1_COMPLETE = true;

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
            $offset = 0;
            while ($offset < strlen($startMol)) {
                $newOffset = strpos($startMol, $replacement['from'], $offset);
                if ($newOffset === false) {
                    break;
                }
                $results[] =
                    substr($startMol, 0, $newOffset) .
                    $replacement['to'] .
                    substr($startMol, $newOffset + strlen($replacement['from']))
                ;
                $offset = $newOffset + strlen($replacement['from']);
            }
        }

        $this->debug(sprintf('Found %d nonunique molecules', count($results)));
        return array_unique($results);
    }
}

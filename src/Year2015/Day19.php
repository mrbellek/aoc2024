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

    public function part2(): void
    {
        //run the replacements in reverse, until we reach the starting molecule 'e'
        $startMol = end($this->input);
        $this->parseInput(array_slice($this->input, 0, -2));

        //construct associative array of reverse replacements
        $replaceReverse = [];
        foreach ($this->replacements as $repl) {
            $replaceReverse[$repl['to']] = $repl['from'];
        }

        //run reverse replacements until we reach 'e'
        //note that $from/$to is switched here from part1
        $currentMol = $startMol;
        $i = 0;
        while ($currentMol !== 'e') {
            $nextMol = $currentMol;
            foreach ($replaceReverse as $from => $to) {
                $nextMol2 = str_replace($from, $to, $nextMol);
                if ($nextMol !== $nextMol2) {
                    $i++;
                    $this->log($nextMol2);
                    $nextMol = $nextMol2;
                }
            }
            $currentMol = $nextMol;

            if ($i % 100 === 0) {
                echo '.';
            }
        }
        echo PHP_EOL;
        $this->log('done!');
        var_dump($i);
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

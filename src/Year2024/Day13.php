<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day13 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    private $machines = [];

    public function part1(): void
    {
        $this->parseMachines(array_chunk($this->input, 4));
        $totalTokens = 0;
        foreach ($this->machines as $i => $machine) {
            $totalTokens += $this->findSolutionTokenCount($i, $machine);
        }

        $this->log(sprintf('The total amount of tokens to win all possible prizes is: %d' . PHP_EOL, $totalTokens));
    }

    public function part2(): void
    {
        $this->parseMachines(array_chunk($this->input, 4));
        $totalTokens = 0.0;
        foreach ($this->machines as $i => $machine) {
            $machine['raw']['px'] += 10_000_000_000_000;
            $machine['raw']['py'] += 10_000_000_000_000;

            $totalTokens += $this->findSolutionTokenCount($i, $machine);
        }

        $this->log(sprintf('The total amount of corrected tokens to win all possible prizes is: %f' . PHP_EOL, $totalTokens));
    }

    private function findSolutionTokenCount(int $index, array $machine): float
    {
        extract($machine['raw']);
        $aButtons = (($px * $by - $bx * $py) / ($by * $ax - $bx * $ay));
        $bButtons = ($py / $by - $ay * $aButtons / $by);

        if ($aButtons == intval($aButtons)) {
            $this->debug(sprintf(
                'Machine %d can be solved with %s A presses and %s B presses.',
                $index + 1,
                $aButtons,
                $bButtons
            ));

            return $aButtons * 3 + $bButtons;
        } else {
            $this->debug(sprintf('Machine %d cannot be solved!', $index + 1));

            return 0;
        }

    }

    private function parseMachines(array $chunks): void
    {
        foreach ($chunks as $i => $chunk) {
            //parse out machine chunk into data
            if (preg_match('/Button A: X\+(\d+), Y\+(\d+)/', $chunk[0], $m) === 1) {
                $this->machines[$i]['a'] = ['x' => $m[1], 'y' => $m[2]];
            }
            if (preg_match('/Button B: X\+(\d+), Y\+(\d+)/', $chunk[1], $m) === 1) {
                $this->machines[$i]['b'] = ['x' => $m[1], 'y' => $m[2]];
            }
            if (preg_match('/Prize: X=(\d+), Y=(\d+)/', $chunk[2], $m) === 1) {
                $this->machines[$i]['prize'] = ['x' => $m[1], 'y' => $m['2']];
            }
            $this->machines[$i]['raw'] = [
                'ax' => $this->machines[$i]['a']['x'],
                'ay' => $this->machines[$i]['a']['y'],
                'bx' => $this->machines[$i]['b']['x'],
                'by' => $this->machines[$i]['b']['y'],
                'px' => $this->machines[$i]['prize']['x'],
                'py' => $this->machines[$i]['prize']['y'],
            ];
        }
    }
}

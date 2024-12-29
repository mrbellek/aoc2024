<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day07 extends AbstractDay
{
    private array $wires = [];

    public function part1(): void
    {
        $ops = [];
        foreach ($this->input as $line) {
            $ops[] = $this->parse($line);
        }

        $executedCount = 1;
        $i = 0;
        while($executedCount > 0) {
            foreach ($ops as $op) {
                if ($this->exec($op)) {
                    $executedCount++;
                }
            }

            $this->log(sprintf('Executed: %d', $executedCount));
            print_r($this->wires);

            $executedCount = 1;
            usleep(100_000);

            $i++;
            if ($i > 1000) {
                die('duurt lang');
            }
        }

        ksort($this->wires);
        $this->printWires();
    }

    private function parse(string $line): array
    {
        $m = [];
        if (preg_match('/^(\w+) -> (\w+)$/', $line, $m) === 1) {
            //123 -> x
            //x -> y
            return [
                'oper' => 'COPY',
                'input1' => $m[1],
                'output' => $m[2],
            ];

        } elseif (preg_match('/^(\w+) ([A-Z]+) (\w+) -> (\w+)$/', $line, $m) === 1) {
            //x AND y -> d
            return [
                'oper' => $m[2],
                'input1' => $m[1],
                'input2' => $m[3],
                'output' => $m[4],
            ];
        } elseif (preg_match('/^([A-Z]+) (\w+) -> (\w+)$/', $line, $m) === 1) {
            //NOT x -> h
            return [
                'oper' => $m[1],
                'input1' => $m[2],
                'output' => $m[3],
            ];
        } else {
            $this->log(sprintf('huh? %s', $line));
            exit(1);
        }
    }

    private function exec(array $op): bool
    {
        $oper = $op['oper'];
        $input1 = $op['input1'];
        $input2 = $op['input2'] ?? '';
        $output = $op['output'];

        $executed = false;
        switch($oper) {
            case 'COPY':
                if (is_numeric($input1)) {
                    //starting input
                    $this->wires[$output] = intval($input1);
                    $executed = true;
                } else {
                    //copy
                    if (isset($this->wires[$input1])) {
                        $this->wires[$output] = $this->wires[$input1];
                        $executed = true;
                    }
                }
                break;
            case 'NOT':
                if (isset($this->wires[$input1])) {
                    $this->wires[$output] = 65536 + ~$this->wires[$input1];
                    $executed = true;
                }
                break;
            case 'AND':
                if (isset($this->wires[$input1]) && isset($this->wires[$input2])) {
                    $this->wires[$output] = $this->wires[$input1] & $this->wires[$input2];
                    $executed = true;
                }
                break;
            case 'OR':
                if (isset($this->wires[$input1]) && isset($this->wires[$input2])) {
                    $this->wires[$output] = $this->wires[$input1] | $this->wires[$input2];
                    $executed = true;
                }
                break;
            case 'LSHIFT':
                if (isset($this->wires[$input1])) {
                    $this->wires[$output] = $this->wires[$input1] << $input2;
                    $executed = true;
                }
                break;
            case 'RSHIFT':
                if (isset($this->wires[$input1])) {
                    $this->wires[$output] = $this->wires[$input1] >> $input2;
                    $executed = true;
                }
                break;
            default:
                $this->log('unknown oper %s', $op['oper']);
                print_r($op);
                exit(1);
        }

        $this->debugPrintWires();
        if ($this->isLive === false && $executed) {
            echo PHP_EOL;
        }

        return $executed;
    }

    private function debugPrintWires(): void
    {
        foreach ($this->wires as $id => $value) {
            $this->debug(sprintf('%s: %s', $id, $value));
        }
    }

    private function printWires(): void
    {
        foreach ($this->wires as $id => $value) {
            $this->log(sprintf('%s: %s', $id, $value));
        }
    }
}

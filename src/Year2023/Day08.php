<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023;

use AdventOfCode\AbstractDay;
use RuntimeException;

class Day08 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    public function part1(): void
    {
        $instructions = $this->input[0];
        $this->debug(sprintf('Instructions for %d lines: %s', count($this->input) - 2, $instructions));
        $nodes = $this->parseNodes(array_slice($this->input, 2));
        
        $startingNodes = $this->findStartingNodes($nodes);
        $this->debug(sprintf('Found %d nodes ending in "A"! (%s)', count($startingNodes), implode(',', $startingNodes)));
        $stepsToZForNode = [];
        foreach ($startingNodes as $startingNode) {
            $stepsToZForNode[] = $this->findStepsToZForNode($startingNode, $nodes, $instructions);
        }
        $this->log(sprintf('Found steps to Z for all nodes (%s), and the LCM is: %s',
            implode(',', $startingNodes),
            $this->getLcmForArray($stepsToZForNode)
        ));
    }

    public function part2(): void
    {
        $instructions = $this->input[0];
        $this->debug(sprintf('Instructions for %d lines: %s', count($this->input) - 2, $instructions));
        $nodes = $this->parseNodes(array_slice($this->input, 2));
       
        $currentStep = 0;
        $currentNode = 'AAA';
        $nextInstruction = $this->getNextInstruction($instructions, $currentStep);
        $this->log(sprintf('Starting! First node: %s', $currentNode));
        while ($currentNode !== 'ZZZ') {
            $currentStep++;
            $nextNode = $nodes[$currentNode][$nextInstruction];
            $this->debug(sprintf('Choosing %s node: %s', $nextInstruction, $nextNode));
            $nextInstruction = $this->getNextInstruction($instructions, $currentStep);
            $currentNode = $nextNode;
            if ($currentStep > 100000) die('shit broken' . PHP_EOL);
        }
        $this->log(sprintf('Arrived at node ZZZ! It took %d steps.', $currentStep));
        
    }

    private function getLcmForArray(array $numbers): GMP
    {
        if (count($numbers) === 2) {
            return gmp_lcm($numbers[0], $numbers[1]);
        }
    
        $num = array_shift($numbers);
        return gmp_lcm($num, getLcmForArray($numbers));
    }
    
    private function findStepsToZForNode(string $startingNode, array $allNodes, string $instructions): int
    {
        $this->debug(sprintf('Starting at node: %s', $startingNode));
        $nextNode = $startingNode;
        $stepsDone = 0;
        for ($i = 0; true; $i++) {
            if ($i >= strlen($instructions)) {
                $i = 0;
            }
            $instruction = substr($instructions, $i, 1);
            $nextNode = $allNodes[$nextNode][$instruction];
            $stepsDone++;
            //$this->debug(sprintf('Next instruction is %s, pointing to node %s', $instruction, $nextNode));
    
            if (substr($nextNode, -1, 1) === 'Z') {
                $this->log(sprintf('Node %s points to node %s after %s steps',
                    $startingNode,
                    $nextNode,
                    $stepsDone
                ));
                
                return $stepsDone;
            }
        }
    }
    
    private function findStartingNodes(array $nodes): array
    {
        $foundNodes = [];
        foreach ($nodes as $node => $nextNodes) {
            if (substr($node, -1, 1) === 'A') {
                $foundNodes[] = $node;
            }
        }
    
        return $foundNodes;
    }
    
    private function getNextInstruction(string $instructions, int $currentStep): string
    {
        //$this->debug(sprintf('getting next instruction from %s at step %d', $instructions, $currentStep));
        while ($currentStep >= strlen($instructions)) {
            $currentStep -= strlen($instructions);
        }
        return substr($instructions, $currentStep, 1);
    }
    
    private function parseNodes(array $lines): array
    {
        $nodes = [];
        for ($i = 0; $i < count($lines); $i++) {
            [$node, $nextNodes] = explode(' = ', $lines[$i]);
            $nodes[$node] = [
                'L' => substr($nextNodes, 1, 3),
                'R' => substr($nextNodes, 6, 3),
            ];
        }
    
        return $nodes;
    }
}

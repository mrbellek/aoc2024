<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day04 extends AbstractDay
{
    private array $matrix = [];

    public function part1(): void
    {
        $xmasCount = [
            'hori' => 0,
            'vert' => 0,
            'dia1' => 0,
            'dia2' => 0,
        ];

        //convert input into matrix
        $this->matrix = $this->convertInputToMatrix();

        $xmasCount['hori'] = $this->checkHorizontalXmas();
        $xmasCount['vert'] = $this->checkVerticalXmas();
        $xmasCount['dia1'] = $this->checkDiagonalLTRXmas();
        $xmasCount['dia2'] = $this->checkDiagonalRTLXmas();

        printf('The matrix contains XMAS: %d horizontally, %d vertically, %d diagonally LRT, %d diagonally RTL' . PHP_EOL,
            $xmasCount['hori'],
            $xmasCount['vert'],
            $xmasCount['dia1'],
            $xmasCount['dia2'],
        );
        printf('This gives a total of %d XMAS' . PHP_EOL, array_sum($xmasCount));
    }

    public function part2(): void
    {
        /*
         * check for:
         * S S
         *  A
         * M M
         * 
         * in any orientation
         * 
         * M S
         *  A
         * M S
         * 
         * M M
         *  A
         * S S
         * 
         * S M
         *  A
         * S M
         * 
         * NOT:
         * 
         * S M 
         *  A
         * M S 
         */
        foreach ($this->matrix as $line) {

        }
    }

    private function convertInputToMatrix(): array
    {
        $matrix = [];
        foreach ($this->input as $i => $line) {
            $matrix[$i] = str_split($line);
        }

        return $matrix;
    }

    private function checkHorizontalXmas(): int
    {
        //check horizontal
        $count = 0;
        foreach ($this->input as $line) {
            $count += substr_count($line, 'XMAS');
            $count += substr_count($line, 'SAMX');
        }

        return $count;
    }

    private function checkVerticalXmas(): int
    {
        //check vertical
        $count = 0;
        for ($i = 0; $i < count($this->matrix[0]); $i++) {
            $vertline = array_column($this->matrix, $i);
            $count += substr_count(implode('', $vertline), 'XMAS');
            $count += substr_count(implode('', $vertline), 'SAMX');
        }

        return $count;
    }

    private function checkDiagonalLTRXmas(): int
    {
        $count = 0;
        foreach ($this->matrix as $i => $line) {
            foreach ($line as $j => $char) {
                if (
                    $char == 'X' &&
                    $this->getCharAtPos($i+1, $j+1) == 'M' &&
                    $this->getCharAtPos($i+2, $j+2) == 'A' &&
                    $this->getCharAtPos($i+3, $j+3) == 'S')
                {
                    //xmas! topleft to bottomright
                    $count++;

                } elseif (
                    $char == 'S' &&
                    $this->getCharAtPos($i+1, $j+1) == 'A' &&
                    $this->getCharAtPos($i+2, $j+2) == 'M' &&
                    $this->getCharAtPos($i+3, $j+3) == 'X')
                {
                    //xmas! bottomright to topleft
                    $count++;
                }
            }
        }
        
        return $count;
    }

    private function checkDiagonalRTLXmas(): int
    {
        $count = 0;
        foreach ($this->matrix as $i => $line) {
            foreach ($line as $j => $char) {
                if (
                    $char == 'X' &&
                    $this->getCharAtPos($i+1, $j-1) == 'M' &&
                    $this->getCharAtPos($i+2, $j-2) == 'A' &&
                    $this->getCharAtPos($i+3, $j-3) == 'S')
                {
                    //xmas! topright to bottomleft
                    $count++;
                } elseif (
                    $char == 'S' &&
                    $this->getCharAtPos($i+1, $j-1) == 'A' &&
                    $this->getCharAtPos($i+2, $j-2) == 'M' &&
                    $this->getCharAtPos($i+3, $j-3) == 'X')
                {
                    //xmas! bottomleft to topright
                    $count++;
                }
            }
        }

        return $count;
    }

    private function getCharAtPos(int $x, int $y): string
    {
        if (isset($this->matrix[$x]) && isset($this->matrix[$x][$y])) {
            return $this->matrix[$x][$y];
        }

        return '';
    }
}

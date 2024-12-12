<?php

declare(strict_types=1);

namespace AdventOfCode;

trait MatrixTrait
{
    private array $matrix;

    public function __construct(string $dataSet)
    {
        parent::__construct($dataSet);
        $this->createMatrix();
    }
    
    public function createMatrix(): void
    {
        foreach ($this->input as $y => $line) {
            $this->matrix[$y] = str_split($line);
        }
    }
}

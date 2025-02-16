<?php

declare(strict_types=1);

namespace AdventOfCode\Traits;

use AdventOfCode\Helpers\InputHelper;
use AdventOfCode\Helpers\Logger;

trait MatrixTrait
{
    private array $matrix;

    public function __construct(
        InputHelper $inputHelper,
        private readonly Logger $logger,
        string $dataSet
    ) {
        parent::__construct($inputHelper, $logger, $dataSet);
        $this->createMatrix();
    }
    
    public function createMatrix(): void
    {
        foreach ($this->input as $y => $line) {
            $this->matrix[$y] = str_split($line);
        }
    }
}

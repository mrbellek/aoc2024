<?php

declare(strict_types=1);

namespace AdventOfCode\Year2025;

use AdventOfCode\AbstractDay;
use AdventOfCode\Traits\MatrixTrait;

class Day07 extends AbstractDay
{
    use MatrixTrait;

    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = false;

    public function part1(): void
    {
        $lineCount = count($this->matrix);
        $rayOffsets = [array_search('S', $this->matrix[0])];
        $newRayOffsets = [];
        $splitCount = 0;
        for ($i = 1; $i < $lineCount; $i++) {
            $line = $this->matrix[$i];
            foreach ($rayOffsets as $ray) {
                if ($line[$ray] === '^') {
                    //ray will split left and right around the splitter
                    $this->debug(sprintf('The beam was split at line %d, offset %d!', $i, $ray));
                    $line[$ray - 1] = '|';
                    $line[$ray + 1] = '|';
                    $newRayOffsets[] = $ray - 1;
                    $newRayOffsets[] = $ray + 1;
                    $splitCount++;
                } else {
                    //ray continues normally
                    $this->debug(sprintf('No split at line %d at offset %d', $i, $ray));
                    $line[$ray] = '|';
                    $newRayOffsets[] = $ray;
                }
            }

            if ($this->isLive === false) {
                $this->printMatrix();
                usleep(300000);
            }

            $this->matrix[$i] = $line;
            $rayOffsets = array_unique($newRayOffsets);
            $newRayOffsets = [];
        }

        $this->printMatrix();
        $this->log(sprintf('The beam was split %d times', $splitCount));
    }
}

<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day09 extends AbstractDay
{
    public function part1(): void
    {
        $blockString = $this->convertInputToBlockString($this->input[0]);
        $this->log(implode('', $blockString));

        //defrag
        $length = count($blockString);
        for ($i = $length - 1; $i >= 0; $i--) {
            $char = $blockString[$i];
            if ($char === '.') {
                continue;
            }

            $firstDotPos = array_search('.', $blockString, true);
            if ($firstDotPos === false) {
                $this->debug($blockString);
                die('no dot found?!');
            }

            $charLen = strlen($char);
            for ($j = 0; $j < $charLen; $j++) {
                $blockString[$firstDotPos + $j] = $char[$j];
            }
            $blockString[$i] = str_repeat('.', strlen($char));

            $this->debug(implode('', $blockString));
            if (!$this->isLive) {
                usleep(100_000);
            }

            //stop when first dot is beyond cursor
            if (in_array('.', array_slice($blockString, 0, $i), true) === false) {
                break;
            }
        }

        //checksum
        $checksum = 0;
        for ($i = 0; $i < $length; $i++) {
            $checksum += $i * (int)$blockString[$i];
        }
        $this->log(sprintf('Done! Checksum is %d.', $checksum));
    }

    private function convertInputToBlockString(string $input): array
    {
        $blocks = array_values(array_filter(str_split($input), static fn(string $index) => $index % 2 === 0, ARRAY_FILTER_USE_KEY));
        $frees = array_values(array_filter(str_split($input), static fn(string $index) => $index % 2 === 1, ARRAY_FILTER_USE_KEY));

        $blockString = [];
        $max = count($blocks);
        for ($i = 0; $i < $max; $i++) {
            array_push($blockString, ...array_fill(0, (int)$blocks[$i], (string)$i));
            array_push($blockString, ...array_fill(0, (int)($frees[$i] ?? 0), '.'));
        }

        return $blockString;
    }
}
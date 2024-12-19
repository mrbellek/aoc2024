<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day09 extends AbstractDay
{
    public function part1(): void
    {
        $blockArray = $this->convertInputToBlockString($this->input[0]);
        if (!$this->isLive) {
            $this->log(implode('', $blockArray));
        }

        //defrag
        $length = count($blockArray);
        for ($i = $length - 1; $i >= 0; $i--) {
            $char = $blockArray[$i];
            if ($char === '.') {
                continue;
            }

            $firstDotPos = array_search('.', $blockArray, true);
            if ($firstDotPos === false) {
                $this->debug($blockArray);
                die('no dot found?!');
            }

            //@TODO a block id is only one space, not however long the stringed id is :(
            $charLen = strlen($char);
            for ($j = 0; $j < $charLen; $j++) {
                $blockArray[$firstDotPos + $j] = $char[$j];
            }
            $blockArray[$i] = str_repeat('.', strlen($char));

            $this->debug(implode('', $blockArray));
            if (!$this->isLive) {
                usleep(10_000);
            }

            //stop when first dot is beyond cursor
            if (in_array('.', array_slice($blockArray, 0, $i), true) === false) {
                break;
            }
        }

        //checksum
        $checksum = 0;
        for ($i = 0; $i < $length; $i++) {
            $checksum += $i * (int)$blockArray[$i];
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
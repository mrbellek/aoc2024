<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day15 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    private array $ingredients;

    public function part1(): void
    {
        $this->parseIngredients();
        if ($this->isLive === false) {
            //sample input has only 2 ingredients, live has 4
            $this->fatal('Code is incompatible with sample input');
        }

        $maxScore = 0;
        $maxSprinkles = 0;
        $maxButterscotch = 0;
        $maxChocolate = 0;
        $maxCandy = 0;
        for ($i = 1; $i <= 100; $i++) {
            for ($j = 1; $j < 100; $j++) {
                for ($k = 1; $k < 100; $k++) {
                    for ($l = 1; $l < 100; $l++) {
                        if ($i + $j + $k + $l !== 100) {
                            continue;
                        }

                        $score = $this->getScore($i, $j, $k, $l);

                        //new max score, save it
                        if ($score > $maxScore) {
                            $maxScore = $score;
                            $maxSprinkles = $i;
                            $maxButterscotch = $j;
                            $maxChocolate = $k;
                            $maxCandy = $l;
                        }
                    }
                }
            }
        }

        print_r($this->ingredients);

        $this->log(sprintf(
            'Maximum score possible was %s by combining %d Butterscotch, %d Cinnamon, %d Chocolate, %d Candy',
            $maxScore,
            $maxSprinkles,
            $maxButterscotch,
            $maxChocolate,
            $maxCandy
        ));
    }

    public function part2(): void
    {
        $this->parseIngredients();

        $maxScore = 0;
        $maxSprinkles = 0;
        $maxButterscotch = 0;
        $maxChocolate = 0;
        $maxCandy = 0;
        for ($i = 1; $i <= 100; $i++) {
            for ($j = 1; $j < 100; $j++) {
                for ($k = 1; $k < 100; $k++) {
                    for ($l = 1; $l < 100; $l++) {
                        if ($i + $j + $k + $l !== 100) {
                            continue;
                        }

                        $score = $this->getScoreWith500Cal($i, $j, $k, $l);

                        //new max score, save it
                        if ($score > $maxScore) {
                            $maxScore = $score;
                            $maxSprinkles = $i;
                            $maxButterscotch = $j;
                            $maxChocolate = $k;
                            $maxCandy = $l;
                        }
                    }
                }
            }
        }

        $this->log(sprintf(
            'Maximum score possible was %s by combining %d Sprinkles, %d Butterscotch, %d Chocolate, %d Candy',
            $maxScore,
            $maxSprinkles,
            $maxButterscotch,
            $maxChocolate,
            $maxCandy
        ));
    }

    private function parseIngredients(): void
    {
        foreach ($this->input as $ingredient) {
            $m = [];
            if (preg_match('/^(\w+): capacity ([-0-9]+), durability ([-0-9]+), flavor ([-0-9]+), texture ([-0-9]+), calories ([-0-9]+)$/', $ingredient, $m) === 1) {
                $this->ingredients[$m[1]] = [
                    'capacity' => $m[2],
                    'durability' => $m[3],
                    'flavor' => $m[4],
                    'texture' => $m[5],
                    'calories' => $m[6],
                ];
            } else {
                $this->fatal('wtf?');
            }
        }
    }

    private function getScore(int $i, int $j, int $k, int $l): int
    {
        $spr = $this->ingredients['Sprinkles'];
        $but = $this->ingredients['Butterscotch'];
        $cho = $this->ingredients['Chocolate'];
        $can = $this->ingredients['Candy'];
        $scoreCap = $i * $spr['capacity']   + $j * $but['capacity']   + $k * $cho['capacity']   + $l * $can['capacity'];
        $scoreDur = $i * $spr['durability'] + $j * $but['durability'] + $k * $cho['durability'] + $l * $can['durability'];
        $scoreFla = $i * $spr['flavor']     + $j * $but['flavor']     + $k * $cho['flavor']     + $l * $can['flavor'];
        $scoreTex = $i * $spr['texture']    + $j * $but['texture']    + $k * $cho['texture']    + $l * $can['texture'];

        if ($scoreCap < 0 || $scoreDur < 0 || $scoreFla < 0 || $scoreTex < 0) {
            return 0;
        }

        return $scoreCap * $scoreDur * $scoreFla * $scoreTex;
    }

    private function getScoreWith500Cal(int $i, int $j, int $k, int $l): int
    {
        $spr = $this->ingredients['Sprinkles'];
        $but = $this->ingredients['Butterscotch'];
        $cho = $this->ingredients['Chocolate'];
        $can = $this->ingredients['Candy'];
        $scoreCap = $i * $spr['capacity']    + $j * $but['capacity']    + $k * $cho['capacity']    + $l * $can['capacity'];
        $scoreDur = $i * $spr['durability']  + $j * $but['durability']  + $k * $cho['durability']  + $l * $can['durability'];
        $scoreFla = $i * $spr['flavor']      + $j * $but['flavor']      + $k * $cho['flavor']      + $l * $can['flavor'];
        $scoreTex = $i * $spr['texture']     + $j * $but['texture']     + $k * $cho['texture']     + $l * $can['texture'];
        $scoreCal = $i * $spr['calories']    + $j * $but['calories']    + $k * $cho['calories']    + $l * $can['calories'];

        if ($scoreCap <= 0 || $scoreDur <= 0 || $scoreFla <= 0 || $scoreTex <= 0 || $scoreCal !== 500) {
            return 0;
        }

        return $scoreCap * $scoreDur * $scoreFla * $scoreTex;
    }
}

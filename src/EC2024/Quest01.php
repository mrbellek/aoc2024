<?php
declare(strict_types=1);

namespace AdventOfCode\EC2024;

use AdventOfCode\AbstractDay;
use InvalidArgumentException;

class Quest01 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    private array $potionsPerEnemyType = [
        'A' => 0,
        'B' => 1,
        'C' => 3,
    ];
    private array $potionsPerEnemyType2 = [
        'A' => 0,
        'B' => 1,
        'C' => 3,
        'D' => 5,
    ];

    public function part1(): void
    {
        $requiredPotions = 0;
        foreach ($this->potionsPerEnemyType as $enemy => $potions) {
            if ($potions === 0) {
                continue;
            }

            $requiredPotions += substr_count($this->input[0], $enemy) * $potions;
        }

        printf('The input enemies require exactly %d potions to kill.' . PHP_EOL, $requiredPotions);
    }

    public function part2(): void
    {
        $enemies = str_split($this->input[0], 2);
        $requiredPotions = 0;
        foreach ($enemies as $enemyPair) {
            $requiredPotions += match ($enemyPair) {
                'Bx', 'Cx', 'Dx', 'xB', 'xC', 'xD' => $this->potionsPerEnemyType2[trim($enemyPair, 'x')],
                'BB', 'CC', 'DD' => $this->potionsPerEnemyType2[substr($enemyPair, 0, 1)] * 2 + 2,
                'AB', 'BA', 'AC', 'CA', 'AD', 'DA', 'BC', 'CB', 'BD', 'DB', 'CD', 'DC' => $this->calc($enemyPair, $this->potionsPerEnemyType2),
                'AA', 'Ax', 'xA', 'xx' => 0,
                default => throw new InvalidArgumentException('Huh? ' . $enemyPair),
            };
        }

        printf('The total amount of potions required to kill all enemies is: %d' . PHP_EOL, $requiredPotions);
    }

    private function calc(string $enemyPair, array $potionsPer): int
    {
        [$enemy1, $enemy2] = str_split($enemyPair, 1);

        return $potionsPer[$enemy1] + $potionsPer[$enemy2] + 2;
    }
}
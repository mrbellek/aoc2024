<?php
declare(strict_types=1);

class AocDay01
{
    private array $input;
    private const SEP = '   ';
    private array $rightCounts = [];

    public function __construct()
    {
        $this->input = file('input01.txt', FILE_IGNORE_NEW_LINES);
//        $this->input = file('sample01.txt', FILE_IGNORE_NEW_LINES);
    }

    private function getLists(): array
    {
        $left = [];
        foreach ($this->input as $line) {
            [$left[], $right[]] = explode(self::SEP, $line);
        }

        return [$left, $right];
    }
       
    public function run(): void
    {
        [$left, $right] = $this->getLists();
        sort($left);
        sort($right);

        $totalDistance = 0;
        for ($i = 0; $i < count($left); $i++) {
            $totalDistance += abs($left[$i] - $right[$i]);
        }

        printf('Total distance: %d' . PHP_EOL, $totalDistance);
    }

    public function run2(): void
    {
        $similarityScore = 0;
        [$left, $right] = $this->getLists();
        $this->rightCounts = array_count_values($right);
        foreach ($left as $leftNum) {
            $count = $this->rightCounts[$leftNum] ?? 0;
            $similarityScore += $leftNum * $count;
        }

        printf('Similarity score: %s' . PHP_EOL, $similarityScore);
    }
}

//(new AocDay01)->run();
(new AocDay01)->run2();
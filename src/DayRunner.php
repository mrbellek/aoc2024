<?php

declare(strict_types=1);

namespace AdventOfCode;

class DayRunner
{
    private string $home;
    private int $selectedYear;
    private int $selectedDay;
    private int $selectedPart;

    public function __construct(array $argv)
    {
        $this->home = getcwd();
        if (count($argv) === 1) {
//            $this->getMostRecentYearDayPart();
            $this->getMenuInputPart();
        } else {
            $this->parseArguments($argv);
        }
    }

    private function parseArguments(array $argv): void
    {
        $year = $argv[1] ?? (int) date('Y');
        $day = $argv[2] ?? '01';
        $part = $argv[3] ?? 1;
        $dataSet = $argv[4] ?? 'test';

        $classFile = sprintf('./src/Year%1$d/Day%2$02d.php', $year, $day);
        $className = sprintf('AdventOfCode\Year%1$d\Day%2$02d', $year, $day);
        $func = sprintf('part%d', $part);

        include_once './src/AbstractDay.php';
        include_once $classFile;

        $class = new $className($dataSet);
        $class->{$func}();
    }
    
    private function getYears(): array
    {
        chdir($this->home . '\src');
        $years = glob('*', GLOB_ONLYDIR);
        rsort($years);

        return $years;
    }
    
    private function getDays(int $year): array
    {
        chdir($this->home . '\src\\Year' . $year);
        $days = array_map(fn ($file) => str_replace('.php', '', $file), glob('*.php'));
        rsort($days);

        return $days;
    }

    private function getMostRecentDay(int $year): string
    {
        return $this->getDays($year)[0];
    }

    private function getMostRecentYear(): string
    {
        return $this->getYears()[0];
    }

    private function getMenuInputPart(): void
    {
        print('Choose part, or change day?' . PHP_EOL);
        
        $year = $this->getMostRecentYear();
        $day = $this->getMostRecentDay((int) str_replace('Year', '', $year));
        printf(
            'Most recent: %s - %s' . PHP_EOL,
            $year,
            $day
        );
        echo '1) Part1' . PHP_EOL . '2) Part2' . PHP_EOL . PHP_EOL . 'd) Change day' . PHP_EOL . PHP_EOL;

        $input = $this->getInput('> ');
        $yearNum = (int) str_replace('Year', '', $year);
        $dayNum = (int) str_replace('Day', '', $day);

        switch ($input) {
            case '1':
            case '2': $this->runDay($yearNum, $dayNum, (int) $input, 'test'); break;
            case 'd': $this->getMenuInputDay();
            default: throw new InvalidArgumentException(sprintf('Invalid menu input "%s"', $input));
        }
    }

    private function getMenuInputDay(): void
    {
        foreach ($days[max($years)] as $day) {
            printf(
                '%d) %s' . PHP_EOL,
                (int) str_replace('Day', '', $day),
                $day
            );
        }

        print(PHP_EOL);
        if (1 || count($years) > 1) {
            foreach ($years as $year) {
                printf(
                    '%d) %s' . PHP_EOL,
                    (int) str_replace('Year', '', $year),
                    $year
                );
            }
        }

        $userInput = $this->getInput('> ');

        switch ($userInput) {
            case '': $this->runDay(reset($years), reset($days)); break;
            case $userInput <= 25: $this->runDay($this->runDay(reset($years), (int) $userInput));

        }
    }

    private function runDay(int $year, int $day, int $part, string $dataSet): void
    {
        chdir($this->home);
        include_once sprintf('%1$s/src/AbstractDay.php', $this->home);
        include_once sprintf('%1$s/src/Year%2$d/Day%3$02d.php', $this->home, $year, $day);

        $dayClass = sprintf('AdventOfCode\Year%1$d\\Day%2$02d', $year, $day);

        $obj = new $dayClass($dataSet);
        $partFunc = sprintf('part%d', $part);
        if (!method_exists($obj, $partFunc)) {
            throw new RuntimeException('Class %s has no method part%d', $dayClass, $part);
        }

        $obj->{$partFunc}();
    }

    private function getInput(string $prompt): string
    {
        echo $prompt;
        $userInput = fgets(fopen('php://stdin', 'r'));

        return rtrim($userInput);
    }
}

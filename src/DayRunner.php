<?php

declare(strict_types=1);

namespace AdventOfCode;

class DayRunner
{
    private string $home;
    private array $availableDays = [];
    private int $selectedYear;
    private string $selectedDay; //string because leading zero, e.g. 08
    private int $selectedPart;
    private string $selectedEnv;

    private const YEAR_PREFIX = 'Year';
    private const DAY_PREFIX = 'Day';

    private const ENV_TEST = 'test';
    private const ENV_LIVE = 'live';

    public function __construct(array $argv)
    {
        $this->home = getcwd();
        if (count($argv) > 1) {
            $this->parseArguments($argv);
        } else {
            $this->scanAvailableDays();
            $this->selectedYear = $this->getMostRecentYear();
            $this->selectedDay = $this->getMostRecentDay($this->selectedYear);
            $this->selectedPart = 2;
            $this->selectedEnv = self::ENV_TEST;

            return $this->showMenu();
        }
    }

    private function showMenu(): void
    {
        /**
         * when no arguments, show menu:
         * - [ENTER] run most recent day+part on test
         * - [1] Change above to live
         * - [2] Change part to [other part]
         * - [3] Change day (submenu)
         * - [4] Change year (submenu)
         * - [r] Completion report
         */
        echo 'Choose a puzzle solution to run:' . PHP_EOL;
        $this->printSelectedYearDayPart();
        $this->printMenu();

        $input = $this->getInput('>');
        $this->processInput($input);
    }

    private function processInput(string $input): void
    {
        switch ($input) {
            case '': $this->runSelected(); break;
            case '1': $this->flipEnv(); $this->showMenu(); break;
            case '2': $this->flipPart(); $this->showMenu(); break;
            case '3': $this->showDayMenu(); break;
            case '4': $this->showYearMenu(); break;
            case 'r': $this->createCompletionReport(); break;
            case 'q':
            case 'x': return;
        }
    }

    private function parseArguments(array $argv): void
    {
        $year = $argv[1] ?? (int) date('Y');
        $day = $argv[2] ?? '01';
        $part = $argv[3] ?? 1;
        $dataSet = $argv[4] ?? 'test';

        $this->runDay((int) $year, $day, (int) $part, $dataSet);
    }

    private function scanAvailableDays(): void
    {
        $years = $this->getYears();
        foreach ($years as $yearStr) {
            $year = (int) str_replace(self::YEAR_PREFIX, '', $yearStr);
            $this->availableDays[$year] = array_map(fn (string $day) => str_replace(self::DAY_PREFIX, '', $day), $this->getDays($year));
        }
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

    private function printSelectedYearDayPart()
    {
        printf('[ ] Year%d / Day%s / Part%d / %s' . PHP_EOL,
            $this->selectedYear,
            $this->selectedDay,
            $this->selectedPart,
            strtoupper($this->selectedEnv)
        );
    }

    private function printMenu(): void
    {
        printf('[1] Change env to %s' . PHP_EOL, strtoupper($this->selectedEnv === self::ENV_TEST ? self::ENV_LIVE : self::ENV_TEST));
        printf('[2] Change part to %d' . PHP_EOL, $this->selectedPart === 1 ? 2 : 1);
        print('[3] Change day ->' . PHP_EOL);
        print('[4] Change year ->' . PHP_EOL);
        print('[r] Completion report' . PHP_EOL);
        print('[x] Exit' . PHP_EOL);
    }
    
    private function flipEnv(): void
    {
        $this->selectedEnv = $this->selectedEnv === self::ENV_TEST ? self::ENV_LIVE : self::ENV_TEST;
    }

    private function flipPart(): void
    {
        $this->selectedPart = $this->selectedPart === 1 ? 2 : 1;
    }

    private function getMostRecentDay(int $year): string
    {
        return $this->availableDays[$year][0];
    }

    private function getMostRecentYear(): int
    {
        return array_keys($this->availableDays)[0];
    }

    private function showDayMenu(): void
    {
        printf(PHP_EOL . 'Choose a day from year %d:' . PHP_EOL, $this->selectedYear);
        foreach ($this->availableDays[$this->selectedYear] as $day) {
            printf('[%1$d] Day%1$02d' . PHP_EOL, $day);
        }
        $input = $this->getInput('>');
        if (is_numeric($input)) {
            $this->selectedDay = str_pad($input, 2, '0', STR_PAD_LEFT);
        }

        $this->showMenu();
    }

    private function showYearMenu(): void
    {
        print(PHP_EOL . 'Choose a year:' . PHP_EOL);
        foreach (array_keys($this->availableDays) as $year) {
            printf('[%1$d] Year%1$d' . PHP_EOL, $year);
        }
        $input = $this->getInput('>');
        if (is_numeric($input)) {
            $this->selectedYear = (int) $year;
            $this->selectedDay = $this->availableDays[$year][0];
        }

        $this->showMenu();
    }
    
    private function runSelected(): void
    {
        $this->runDay(
            $this->selectedYear,
            $this->selectedDay,
            $this->selectedPart,
            $this->selectedEnv
        );
    }

    private function runDay(int $year, string $day, int $part, string $dataSet): void
    {
        $classFile = sprintf('%1$s/src/Year%2$d/Day%3$02d.php', $this->home, $year, $day);

        chdir($this->home);
        if (is_readable($classFile) === false) {
            printf('FATAL: Cannot find class file for Year%d/Day%s!' . PHP_EOL, $year, $day);
            print($classFile . PHP_EOL);
            exit(1);
        }
        printf('Loading file %s..' . PHP_EOL, $classFile);
        include_once sprintf('%1$s/src/AbstractDay.php', $this->home);
        include_once sprintf('%1$s/src/MatrixTrait.php', $this->home);
        include_once $classFile;

        $className = sprintf('AdventOfCode\Year%1$d\\Day%2$02d', $year, $day);
        printf('Loading class %s..' . PHP_EOL, $className);
        $obj = new $className($dataSet);
        
        printf('Running part%d with %s data!' . PHP_EOL, $part, $dataSet);
        print(str_repeat('=', 30) . PHP_EOL);
        $partFunc = sprintf('part%d', $part);

        $t = microtime(true);
        $obj->{$partFunc}();
        $runtime = microtime(true) - $t;

        print(str_repeat('=', 30) . PHP_EOL);
        if ($runtime < 0.1) {
            printf('Runtime: %1$.3f us' . PHP_EOL, 1_000_000 * $runtime);
        } elseif ($runtime < 1) {
            printf('Runtime: %1$.3f ms' . PHP_EOL, 1_000 * $runtime);
        } else {
            printf('Runtime: %1$.3f s' . PHP_EOL, $runtime);
        }
    }

    private function getInput(string $prompt): string
    {
        echo $prompt;
        $userInput = fgets(fopen('php://stdin', 'r'));

        return rtrim($userInput);
    }

    private function createCompletionReport(): void
    {
        $completedDays = [];

        chdir($this->home);
        include_once sprintf('%1$s/src/AbstractDay.php', $this->home);
        include_once sprintf('%1$s/src/MatrixTrait.php', $this->home);
        foreach ($this->availableDays as $year => $days) {
            $completedDays[$year] = [];
            sort($days);
            foreach ($days as $day) {
                $completedDays[$year][$day] = '.';
                $classFile = sprintf('%1$s/src/Year%2$d/Day%3$02d.php', $this->home, $year, $day);
                include_once $classFile;

                $className = sprintf('AdventOfCode\Year%1$d\\Day%2$02d', $year, $day);
                if ($className::PART1_COMPLETE) {
                    $completedDays[$year][$day] = '*';
                }
                if ($className::PART2_COMPLETE) {
                    $completedDays[$year][$day] = '**';
                }
            }
        }

        $this->showCompletionReport($completedDays);
    }

    private function showCompletionReport(array $completedDays): void
    {
        ksort($completedDays);
        $years = array_keys($completedDays);
        print '       | ' . implode(' | ', $years) . PHP_EOL;
        print str_repeat('-', 8 + count($years) * 7) . PHP_EOL;
        for ($i = 1; $i <= 25; $i++) {
            $day = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            printf('Day %s |  ', $day);
            foreach ($years as $year) {
                print str_pad($completedDays[$year][$day] ?? '', 4, ' ', STR_PAD_RIGHT);
                echo '|  ';
            }
            echo PHP_EOL;

        }
    }
}

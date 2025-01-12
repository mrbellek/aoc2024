<?php

declare(strict_types=1);

namespace AdventOfCode\Helpers;

use AdventOfCode\AbstractDay;

class InputHelper
{
    public function __construct()
    {
        $this->logger = new Logger();
    }

    public function getInput(AbstractDay $class, string $dataSet, bool $raw): array|string
    {
        [$year, $day] = $this->getClassYearAndDay($class);

        switch ($dataSet) {
            case 'test':
                $this->isLive = false;
                $inputFile = sprintf('./data/%1$d/sample%2$02d.txt', $year, $day);
                break;
            case 'live':
                $this->isLive = true;
                $inputFile = sprintf('./data/%1$d/input%2$02d.txt', $year, $day);
                break;
            default:
                $this->logger->fatal(sprintf('Invalid environment "%s"', $dataSet));
                exit(1);
        }

        if (!is_readable($inputFile)) {
            $this->logger->fatal(sprintf('FATAL: Cannot find input file %s!', $inputFile));
            exit(1);
        }


        return $raw ? file_get_contents($inputFile) : file($inputFile, FILE_IGNORE_NEW_LINES);
    }
    
    private function getClassYearAndDay(AbstractDay $class): array
    {
        $className = get_class($class);
        $year = (int) date('Y');
        $day = 1;
        $matches = [];
        if (preg_match('/Year(\d+)\\\Day(\d+)/', $className, $matches) === 1) {
            $year = $matches[1];
            $day = $matches[2];
        }

        return [$year, $day];
    }
}

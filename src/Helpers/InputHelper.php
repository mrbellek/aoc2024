<?php

declare(strict_types=1);

namespace AdventOfCode\Helpers;

use AdventOfCode\AbstractDay;

class InputHelper
{
    private Logger $logger;
    private string $folderPrefix;
    private string $yearPrefix;
    private string $dayPrefix;
    private string $partPrefix;

    public function __construct(string $campaign)
    {
        $this->logger = new Logger();
        $this->yearPrefix = match($campaign) {
            'aoc' => 'Year',
            'ec' => 'EC',
        };
        $this->dayPrefix = match($campaign) {
            'aoc' => 'Day',
            'ec' => 'Quest',
        };
        $this->folderPrefix = match($campaign) {
            'aoc' => '',
            'ec' => 'ec',
        };
        $this->partPrefix = match($campaign) {
            'aoc' => '',
            'ec' => '-',
        };
    }

    public function getInput(AbstractDay $class, string $dataSet, int $part, bool $raw): array|string
    {
        [$year, $day] = $this->getClassYearAndDay($class);

        $partPrefix = $this->partPrefix === '' ? '' : $this->partPrefix . $part;

        switch ($dataSet) {
            case 'test':
                $inputFile = sprintf('./data/%1$s%2$d/sample%3$02d%4$s.txt', $this->folderPrefix, $year, $day, $partPrefix);
                break;
            case 'live':
                $inputFile = sprintf('./data/%1$s%2$d/input%3$02d%4$s.txt', $this->folderPrefix, $year, $day, $partPrefix);
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
        if (preg_match('/' . $this->yearPrefix . '(\d+)\\\\' . $this->dayPrefix . '(\d+)/', $className, $matches) === 1) {
            $year = $matches[1];
            $day = $matches[2];
        }

        return [$year, $day];
    }
}

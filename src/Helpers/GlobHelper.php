<?php

declare(strict_types=1);

namespace AdventOfCode\Helpers;

use AdventOfCode\Helpers\Logger;

class GlobHelper
{
    private Logger $logger;
    private string $home;
    private string $yearPrefix;
    private string $dayPrefix;

    public function __construct(string $campaign)
    {
        $this->logger = new Logger();
        $this->home = dirname(__DIR__, 2);
        $this->yearPrefix = match($campaign) {
            'aoc' => 'Year',
            'ec' => 'EC',
        };
        $this->dayPrefix = match($campaign) {
            'aoc' => 'Day',
            'ec' => 'Quest',
        };
    }

    public function getYears(): array
    {
        chdir($this->home . '/src');
        $years = glob($this->yearPrefix . '*', GLOB_ONLYDIR) ?: [];
        rsort($years);

        return $years;
    }

    public function getDays(int $year): array
    {
        $dir = $this->home . '/src/' . $this->yearPrefix . $year;
        if (is_dir($dir)) {
        chdir($dir);
        } else {
            $this->logger->fatal(sprintf('Cant chdir to %s', $dir));
        }

        $days = array_map(
            static fn($file) => str_replace('.php', '', $file),
            glob('*.php') ?: []
        );
        rsort($days);

        return $days;
    }
}
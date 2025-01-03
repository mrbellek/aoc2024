<?php

declare(strict_types=1);

namespace AdventOfCode\Helpers;

use AdventOfCode\Traits\LoggerTrait;

class GlobHelper
{
    use LoggerTrait;

    private string $home;

    public function __construct()
    {
        $this->home = dirname(__DIR__, 2);
    }

    public function getYears(): array
    {
        chdir($this->home . '/src');
        $years = glob('Year*', GLOB_ONLYDIR) ?: [];
        rsort($years);

        return $years;
    }

    public function getDays(int $year): array
    {
        $dir = $this->home . '/src/Year' . $year;
        if (is_dir($dir)) {
        chdir($dir);
        } else {
            $this->fatal(sprintf('Cant chdir to %s', $dir));
        }

        $days = array_map(
            static fn($file) => str_replace('.php', '', $file),
            glob('*.php') ?: []
        );
        rsort($days);

        return $days;
    }
}
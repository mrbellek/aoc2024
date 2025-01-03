<?php

declare(strict_types=1);

namespace AdventOfCode\Helpers;

class Logger
{
    public function debug(string $s): void
    {
        $this->log($s);
    }

    public function log(string $s): void
    {
        print($s . PHP_EOL);
    }

    public function fatal(string $s): void
    {
        $this->log($s);
    }
}

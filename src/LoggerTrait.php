<?php

declare(strict_types=1);

namespace AdventOfCode;

trait LoggerTrait
{
    protected function log(string $s): void
    {
        print($s . PHP_EOL);
    }

    protected function debug(string $s): void
    {
        if (!isset($this->isLive) || $this->isLive === false) {
            print($s . PHP_EOL);
        }
    }

    protected function fatal(string $s): void
    {
        $this->log($s);
        exit(1);
    }
}

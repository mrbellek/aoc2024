<?php

declare(strict_types=1);

namespace AdventOfCode;

class DataSetEnum
{
    public const TEST = 'test';
    public const LIVE = 'live';

    public const ALLOWED_VALUES = [
        self::TEST,
        self::LIVE,
    ];
}

<?php
$argv = $_SERVER['argv'];

require 'vendor/autoload.php';

// Runner wrapper for Everybody Codes - @see https://https://everybody.codes/home
(new AdventOfCode\DayRunner(
    new AdventOfCode\Helpers\GlobHelper('ec'),
    new AdventOfCode\Helpers\Logger(),
    'ec',
    $argv
));

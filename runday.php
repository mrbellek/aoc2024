<?php
$argv = $_SERVER['argv'];

require 'vendor/autoload.php';

// Runner wrapper for Advent of Code - @see https://adventofcode.com/
(new AdventOfCode\DayRunner(
    new AdventOfCode\Helpers\GlobHelper('aoc'),
    new AdventOfCode\Helpers\Logger(),
    'aoc',
    $argv
));

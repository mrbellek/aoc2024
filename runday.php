<?php
$argv = $_SERVER['argv'];

require 'vendor/autoload.php';

(new AdventOfCode\DayRunner(new AdventOfCode\Helpers\GlobHelper(), $argv));

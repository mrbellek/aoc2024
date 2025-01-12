<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use  AdventOfCode\AbstractDay;

class Day11 extends AbstractDay
{
    public const PART1_COMPLETE = true;
    public const PART2_COMPLETE = true;

    public function part1(): void
    {
        if ($this->isLive === true) {
            $password = $this->input[0];
            $this->log(sprintf('Looking for next password after "%s"...', $password));
            while ($this->isValidPassword($password) === false) {
                $password = $this->getNextPassword($password);
            }
            $this->log(sprintf('New password: %s', $password));
        } else {
            //test
            $testPasswords = [
                'hijklmmn',
                'abbceffg',
                'abbcegjk',
            ];
            foreach ($testPasswords as $password) {
                $this->debug(sprintf('%s is valid: %s',
                    $password,
                    $this->isValidPassword($password) ? 'true' : 'false'
                ));
            }

            $nextPasswords = [
                'abcdefgh',
                'ghijklmn',
            ];
            foreach ($nextPasswords as $password) {
                $oldPassword = $password;
                $password = $this->getNextPassword($password);
                while ($this->isValidPassword($password) === false) {
                    $password = $this->getNextPassword($password);
                }
                $this->debug(sprintf('The next password after %s is %s',
                    $oldPassword,
                    $password
                ));
            }
        }
    }

    public function part2(): void
    {
        if ($this->isLive === true) {
            $password = $this->input[0];
            $this->log(sprintf('Looking for next password after "%s"...', $password));
            while ($this->isValidPassword($password) === false) {
                $password = $this->getNextPassword($password);
            }
            $this->log(sprintf('New password: %s', $password));

            $this->log(sprintf('Looking for next password after "%s"...', $password));
            $password = $this->getNextPassword($password);
            while ($this->isValidPassword($password) === false) {
                $password = $this->getNextPassword($password);
            }
            $this->log(sprintf('New password: %s', $password));
        } else {
            $this->fatal('no sample input for part2.');
        }
    }

    private function isValidPassword(string $password): bool
    {
        return $this->hasNoIOL($password) && $this->hasStraight($password) && $this->hasPairs($password);
    }

    private function hasNoIOL(string $password): bool
    {
        //Password may not contain i, o, l
        if (
            str_contains($password, 'i') ||
            str_contains($password, 'o') ||
            str_contains($password, 'l')
        ) {
            return false;
        }

        return true;
    }

    private function hasStraight(string $password): bool
    {
        //Password must include one increasing straight
        //of at last three letters.
        $increments = [
            'abc', 'bcd', 'cde', 'def', 'efg',
            'fgh', 'ghi', 'hij', 'ijk', 'jkl',
            'klm', 'lmn', 'mno', 'nop', 'opq',
            'pqr', 'qrs', 'rst', 'stu', 'tuv',
            'uvw', 'vwx', 'wxy', 'xyz',
        ];
        $incrementPresent = false;
        foreach ($increments as $inc) {
            if (str_contains($password, $inc) === true) {
                $incrementPresent = true;
            }
        }
        if ($incrementPresent === false) {
            return false;
        }

        return true;
    }

    private function hasPairs(string $password): bool
    {
        $m = [];
        if (preg_match_all('/(\w)\1/', $password, $m) > 1) {
            if (count($m[0]) >= 2) {
                return true;
            }
        }

        return false;
    }

    private function getNextPassword(string $password): string
    {
        //the answer of course, is recursion
        return $this->increment($password, strlen($password) - 1);
    }

    private function increment(string $s, int $index): string
    {
        if (substr($s, $index, 1) !== 'z') {
            //php refuses to increment a letter if it's not in a separate var
            $char = $s[$index];
            $char++;
            $s[$index] = $char;

            return $s;
        } else {
            $s[$index] = 'a';
            return $this->increment($s, $index - 1);
        }
    }
}

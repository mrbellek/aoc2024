<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use  AdventOfCode\AbstractDay;

class Day11 extends AbstractDay
{
    public function part1(): void
    {
        die(var_dump($this->getNextPassword('abcxyz')));
        if ($this->isLive === true) {
            $password = $this->input[0];
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
                $this->debug(sprintf('The next password after %s is %s',
                    $password,
                    $this->getNextPassword($password)
                ));
            }
        }
    }

    private function isValidPassword(string $password): bool
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
            $this->debug(sprintf('password %s invalid because no increasing 3-straight', $password));
            return false;
        }

        //Password may not contain i, o, l
        if (
            str_contains($password, 'i') ||
            str_contains($password, 'o') ||
            str_contains($password, 'l')
        ) {
            $this->debug(sprintf('password %s invalid because it has i/o/l', $password));
            return false;
        }

        if (preg_match_all('/(\w)\1/', $password, $m) > 1) {
            if (count($m[0]) < 2) {
                $this->debug(sprintf('password %d invalid because no two pairs', $password));
                return false;
            }
        }

        return true;
    }

    private function getNextPassword(string $password): string
    {
        /**
         * TODO:
         * - convert password to base-26 'numbers', i.e. substract 10 from everything
         * - convert to decimal
         * - add 1
         * - convert back to base-26
         * - add 10 to everything
         */
        $table = [
            'a' => '0',
            'b' => '1',
            'c' => '2',
            'd' => '3',
            'e' => '4',
            'f' => '5',
            'g' => '6',
            'h' => '7',
            'i' => '8',
            'j' => '9',
        ];
        $temp = '';
        for ($i = 0; $i < strlen($password); $i++) {
            if (ord($password[$i]) > 106) {
                //result is a letter
                $temp .= chr(ord($password[$i]) - 10);
            } else {
                //result has to be a number
                $temp .= $table[$password[$i]];
            }
        }

        $temp = base_convert(strval(base_convert($temp, 26, 10) + 1), 10, 26);
        $this->debug($temp);

        $table = array_flip($table);
        $temp2 = '';
        for ($i = 0; $i < strlen($temp); $i++) {
            if (is_numeric($temp[$i])) {
                $temp2 .= $table[$temp[$i]];
            } else {
                $temp2 .= chr(ord($temp[$i]) + 10);
            }
        }

        return $temp2;
    }
}

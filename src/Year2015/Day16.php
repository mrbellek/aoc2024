<?php

declare(strict_types=1);

namespace AdventOfCode\Year2015;

use AdventOfCode\AbstractDay;

class Day16 extends AbstractDay
{
    public const PART1_COMPLETE = true;

    private array $sues;

    public function part1(): void
    {
        if ($this->isLive === false) {
            $this->fatal('This assignment has no sample input.');
        }

        $this->parseSues();
        $sueId = $this->findSue([
            'kids' => 3,
            'cats' => 7,
            'samo' => 2,
            'poms' => 3,
            'akit' => 0,
            'vizs' => 0,
            'fish' => 5,
            'tree' => 3,
            'cars' => 2,
            'perf' => 1,
        ]);
        $this->log(sprintf('Your present was sent to you by Sue %d', $sueId));
    }

    private function parseSues(): void
    {
        foreach ($this->input as $sueLine) {
            $m = [];
            if (preg_match('/^Sue (\d+): (.+)$/', $sueLine, $m)) {
                $sueId = $m[1];
                $this->sues[$sueId] = [
                    'kids' => $this->getCount('children', $m[2]),
                    'cats' => $this->getCount('cats', $m[2]),
                    'samo' => $this->getCount('samoyeds', $m[2]),
                    'poms' => $this->getCount('pomeranians', $m[2]),
                    'akit' => $this->getCount('akitas', $m[2]),
                    'vizs' => $this->getCount('vizslas', $m[2]),
                    'fish' => $this->getCount('goldfish', $m[2]),
                    'tree' => $this->getCount('trees', $m[2]),
                    'cars' => $this->getCount('cars', $m[2]),
                    'perf' => $this->getCount('perfumes', $m[2]),
                ];
            }
        }
    }

    private function getCount(string $keyword, string $line): ?int
    {
       if (preg_match('/' . $keyword . ': (\d+)/', $line, $m)) {
           return (int)$m[1];
       } else {
           return null;
       }
    }

    private function findSue(array $params): int
    {
       foreach ($this->sues as $id => $sue) {
           if ($this->sortaEquals($sue['kids'], $params['kids']) &&
               $this->sortaEquals($sue['cats'], $params['cats']) &&
               $this->sortaEquals($sue['samo'], $params['samo']) &&
               $this->sortaEquals($sue['poms'], $params['poms']) &&
               $this->sortaEquals($sue['akit'], $params['akit']) &&
               $this->sortaEquals($sue['vizs'], $params['vizs']) &&
               $this->sortaEquals($sue['fish'], $params['fish']) &&
               $this->sortaEquals($sue['tree'], $params['tree']) &&
               $this->sortaEquals($sue['cars'], $params['cars']) &&
               $this->sortaEquals($sue['perf'], $params['perf'])
           ) {
               return $id;
           }
       }

       throw new \RuntimeException('ZOMG SUE NOT FOUND');
    }

    private function sortaEquals(?int $val1, int $val2): bool
    {
        return $val1 === null || $val1 === $val2;
    }
}

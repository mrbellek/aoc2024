<?php

declare(strict_types=1);

namespace AdventOfCode\Year2024;

use AdventOfCode\AbstractDay;

class Day23 extends AbstractDay
{
    public const PART1_COMPLETE = true;

    public function part1(): void
    {
        $connections = $this->makeNetworkMap();
        $groups = [];
        foreach ($connections as $lan1 => $peers) {
            foreach ($peers as $lan2) {
                foreach ($connections[$lan2] as $lan3) {
                    foreach ($connections[$lan3] as $lan4) {
                        if ($lan4 === $lan1) {
                            $group = [$lan1, $lan2, $lan3];
                            sort($group);
                            $groups[implode('', $group)] = $group;
                        }
                    }
                }
            }
        }
        $groups = array_values(($groups));
        sort($groups);

        $tGroups = 0;
        foreach ($groups as $group) {
            if (str_starts_with($group[0], 't') || str_starts_with($group[1], 't') || str_starts_with($group[2], 't')) {
                $tGroups++;
            }
        }

        $this->log(sprintf('%d LAN groups have a computer that starts with "t" in them.', $tGroups));
    }

    private function makeNetworkMap(): array
    {
        $connections = [];
        //make associative map
        foreach ($this->input as $connection) {
            [$lan1, $lan2] = explode('-', $connection);
            if (!isset($connections[$lan1])) {
                $connections[$lan1] = [];
            }
            $connections[$lan1][] = $lan2;

            if (!isset($connections[$lan2])) {
                $connections[$lan2][] = $lan1;
            }
            $connections[$lan2][] = $lan1;
        }

        foreach ($connections as $lan1 => $peers) {
            $this->debug(sprintf('%s is connected to: %s', $lan1, implode(', ', $peers)));
        }

        return $connections;
    }
}

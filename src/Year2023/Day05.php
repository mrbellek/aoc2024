<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023;

use AdventOfCode\AbstractDay;

class Day05 extends AbstractDay
{
    public const PART1_COMPLETE = true;

    public function part1(): void
    {
        $seeds = explode(' ', str_replace('seeds: ', '', $this->input[0]));
        $seedToSoilMap = this->getMapByHeader($this->input, 'seed-to-soil map:');
        $soilToFertilizerMap = this->getMapByHeader($this->input, 'soil-to-fertilizer map:');
        $fertilizerToToWaterMap = this->getMapByHeader($this->input, 'fertilizer-to-water map:');
        $waterToLightMap = this->getMapByHeader($this->input, 'water-to-light map:');
        $lightToTemperatureMap = this->getMapByHeader($this->input, 'light-to-temperature map:');
        $temperatureToHumidityMap = this->getMapByHeader($this->input, 'temperature-to-humidity map:');
        $humidityToLocationMap = this->getMapByHeader($this->input, 'humidity-to-location map:');
        
        $locations = [];
        foreach ($seeds as $seed) {
            $soilForSeed =this-> getDestinationForSource($seed, $seedToSoilMap);
            //$this->log(sprintf('seed %s moet in soil %s', $seed, $soilForSeed));
            $fertilizerForSoil = this->getDestinationForSource($soilForSeed, $soilToFertilizerMap);
            //$this->log(sprintf('soil %s moet in fertilizer %s', $soilForSeed, $fertilizerForSoil));
            $waterForFertilizer = this->getDestinationForSource($fertilizerForSoil, $fertilizerToToWaterMap);
            //$this->log(sprintf('fertilizer %s moet in water %s', $fertilizerForSoil, $waterForFertilizer));
            $lightForWater = this->getDestinationForSource($waterForFertilizer, $waterToLightMap);
            $tempForLight = this->getDestinationForSource($lightForWater, $lightToTemperatureMap);
            $humidityToTemp = this->getDestinationForSource($tempForLight, $temperatureToHumidityMap);
            $locationForHumidity = this->getDestinationForSource($humidityToTemp, $humidityToLocationMap);
            $locations[] = $locationForHumidity;
            $this->debug(sprintf('seed %s moet in location %s', $seed, $locationForHumidity));
        }
        $this->log(sprintf('en de laagste location is dus %s', min($locations)));
    }
    
    private function getDestinationForSource(int $seed, array $map)
    {
        $sources = $map['source'];
        $destinations = $map['destination'];
        foreach ($sources as $i => $source) {
            if ($source['start'] <= $seed && $source['end'] >= $seed) {
                return $seed + ($destinations[$i]['start'] - $source['start']);
            }
        }
    
        return $seed;
    }
    
    private function getMapByHeader(array $input, string $header): array
    {
        $mapLines = [];
        $found = false;
        foreach ($input as $i => $line) {
            if ($line == '' && $found) {
                break;
            }
            if ($found) {
                $mapLines[] = $line;
            }
            if ($line == $header) {
                $found = true;
            }
        }
    
        $map = ['destination' => [], 'source' => []];
        foreach ($mapLines as $mapLine) {
            $nums = explode(' ', $mapLine);
            $map['destination'][] = [
                'start' => intval($nums[0]),
                'length' => intval($nums[2]),
                'end' => $nums[0] + $nums[2] - 1,
            ];
            $map['source'][] = [
                'start' => intval($nums[1]),
                'length' => intval($nums[2]),
                'end' => $nums[1] + $nums[2] - 1,
            ];
        }

        return $map;
    }
}

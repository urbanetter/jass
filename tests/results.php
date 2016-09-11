<?php

$strategyName = $argv[1];

$fileName = __DIR__ . "/../data/${strategyName}_strategy.csv";

if (!file_exists($fileName)) {
    echo "Unknown strategy $strategyName\n";
    die;
}

$lines = file($fileName);

array_shift($lines);

$wins = array_map(function($line) {
    $values = explode(",", $line);
    return $values[0];
}, $lines);

$matches = array_map(function($line) {
    $values = explode(",", $line);
    return $values[1];
}, $lines);

$contraMatches = array_map(function($line) {
    $values = explode(",", $line);
    return $values[2];
}, $lines);

echo "Recorded sets of 1000 games: " . count($lines) . "\n";
echo "Average wins out of 1000 games: " . (round(array_sum($wins) / count($wins))) . "\n";
echo "Average matches out of 1000 games: " . (round(array_sum($matches) / count($matches)) + round(array_sum($contraMatches) / count($contraMatches))) . "\n";
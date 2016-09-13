<?php

use Jass\Entity\Trick;
use function Jass\Table\deal;

require (__DIR__ . "/../vendor/autoload.php");

$strategyName = $argv[1];

$className = 'Jass\\Strategy\\' . ucfirst($strategyName);
if (!class_exists($className)) {
    echo "Unknown strategy $strategyName";
    die;
}

list ($teams, $players) = require 'teamsetup.php';

$gameStyle = new \Jass\GameStyle\TopDown();
/** @var Jass\Strategy\Strategy $strategy */
$strategy = new $className();

$data = [];
for ($i = 0; $i < 1000; $i++) {
    $cards = \Jass\CardSet\jassSet();
    shuffle($cards);
    deal($cards, $players);

    $player = $players[0];
    $playedTricks = [];

    echo ".";

    while ($player->hand) {
        $trick = new Trick();

        while(!\Jass\Trick\isFinished($trick, $players)) {
            $card = $strategy->nextCard($gameStyle, $trick, $player);

            \Jass\Player\playTurn($trick, $player, $card);

            $player = $player->nextPlayer;
        }

        $player = \Jass\Trick\winner($trick, $gameStyle);
        $strategy->lookAtTrick($trick);

        $playedTricks[] = $trick;
    }

    $points = $gameStyle->teamPoints($playedTricks, $teams[0]);

    $data[] = $points;
}

echo "\nStats\n";
echo "Wins: " . count(array_filter($data, function($points) { return $points > 78;})) . "\n";
echo "Matches: " . count(array_filter($data, function($points) { return $points == 257;})) . "\n";
echo "Kontermacthes: " . count(array_filter($data, function($points) { return $points == 0;})) . "\n";

$line = [];
$line[] = count(array_filter($data, function($points) { return $points > 78;}));
$line[] = count(array_filter($data, function($points) { return $points == 257;}));
$line[] = count(array_filter($data, function($points) { return $points == 0;}));

file_put_contents(__DIR__ . "/../data/${strategyName}_strategy.csv", implode(", ", $line) . "\n", FILE_APPEND);
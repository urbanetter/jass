<?php

use Jass\Entity\Trick;
use function Jass\Table\deal;

require (__DIR__ . "/../vendor/autoload.php");

list ($teams, $players) = require 'teamsetup.php';

$gameStyle = new \Jass\GameStyle\TopDown();
$strategy = new \Jass\Strategy\Dumb();

$data = [];
for ($i = 0; $i < 1000; $i++) {
    $cards = \Jass\CardSet\jassSet();
    shuffle($cards);
    deal($cards, $players);

    $player = $players[0];
    $playedTricks = [];

    while ($player->hand) {
        $trick = new Trick();

        while(!\Jass\Trick\isFinished($trick, $players)) {
            $card = $strategy->nextCard($gameStyle, $trick, $player);

            \Jass\Player\playTurn($trick, $player, $card);

            $player = $player->nextPlayer;
        }

        $player = \Jass\Trick\winner($trick, $gameStyle);

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

file_put_contents(__DIR__ . "/../data/dumb_strategy.csv", implode(", ", $line) . "\n", FILE_APPEND);
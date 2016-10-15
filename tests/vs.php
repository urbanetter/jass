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

$challengingStrategyName = $argv[2];
$challengingClassName = 'Jass\\Strategy\\' . ucfirst($challengingStrategyName);
if (!class_exists($className)) {
    echo "Unknown challenging strategy $challengingStrategyName";
    die;
}

list ($teams, $players) = require 'teamsetup.php';

$gameStyle = new \Jass\GameStyle\TopDown();
/** @var Jass\Strategy\Strategy $strategy */
$strategy = new $className();
$challengingStrategy = new $challengingClassName();

$strategies = [
    $teams[0]->name => $challengingStrategy,
    $teams[1]->name => $strategy,
];

$starting = $players[0];

$data = [];
for ($i = 0; $i < 1000; $i++) {
    $cards = \Jass\CardSet\jassSet();
    shuffle($cards);
    deal($cards, $players);

    $player = $starting;
    $playedTricks = [];

    echo ".";

    while ($player->hand) {
        $trick = new Trick();

        while(!\Jass\Trick\isFinished($trick, $players)) {

            $card = $strategies[$player->team->name]->nextCard($gameStyle, $trick, $player);

            \Jass\Player\playTurn($trick, $player, $card);

            $player = $player->nextPlayer;
        }

        $player = \Jass\Trick\winner($trick, $gameStyle);
        $strategy->lookAtTrick($trick);

        $playedTricks[] = $trick;
    }

    $data[] = [
        $challengingStrategyName => $gameStyle->teamPoints($playedTricks, $teams[0]),
        $strategyName => $gameStyle->teamPoints($playedTricks, $teams[1]),
    ];

    $starting = $starting->nextPlayer;
}

$winners = array_map(function($data) {
    return array_keys($data, max($data))[0];
}, $data);

echo "\n";

foreach (array_count_values($winners) as $strat => $wins) {
    echo "Strategy $strat won $wins times.\n";
}
<?php

use Jass\CardSet;
use Jass\Entity\Trick;
use Jass\Table;

require (__DIR__ . "/../vendor/autoload.php");

echo "Hoi.\n";

list ($teams, $players) = require 'teamsetup.php';

$cardSet = CardSet\jassSet();
shuffle($cardSet);
Table\deal($cardSet, $players);

$gameStyle = new \Jass\GameStyle\TopDown();
$strategy = new \Jass\Strategy\Azeige();

$player = $gameStyle->beginningPlayer($players);
$playedTricks = [];

while ($players[0]->hand) {
    $trick = new Trick();

    echo "\nNew Trick\n";

    while(!\Jass\Trick\isFinished($trick, $players)) {
        $card = $strategy->nextCard($gameStyle, $trick, $player);

        echo $player . " plays " . $card . "\n";

        \Jass\Player\playTurn($trick, $player, $card);

        $player = $player->nextPlayer;
    }

    $player = \Jass\Trick\winner($trick, $gameStyle);
    $strategy->lookAtTrick($trick);

    echo "Points: " . \Jass\Trick\points($trick, $gameStyle) . " for team " . $player->team . "\n";
    $playedTricks[] = $trick;
}

echo "Done.\n";

foreach ($teams as $team) {
    echo "Result of team " . $team . ": " . $gameStyle->teamPoints($playedTricks, $team) . "\n";
}


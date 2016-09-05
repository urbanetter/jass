<?php

use Jass\Entity\Trick;
use function Jass\Table\deal;

require (__DIR__ . "/../vendor/autoload.php");

list ($teams, $players) = require 'teamsetup.php';

$gameStyle = new \Jass\GameStyle\TopDown();
$strategy = new \Jass\Strategy\Simple();

for ($i = 0; $i < 1000; $i++) {
    $cards = unserialize(file_get_contents(__DIR__ . "/../data/fixedSet.serialized"));
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

    echo "Points: " . \Jass\Table\teamPoints($playedTricks, $teams[0], $gameStyle) . "\n";
}


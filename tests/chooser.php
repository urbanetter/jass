<?php

use Jass\CardSet;
use Jass\Entity\Trick;
use Jass\Hand;
use Jass\Table;

require (__DIR__ . "/../vendor/autoload.php");

function writeln($line) {echo $line . "\n";};

list ($teams, $players) = require 'teamsetup.php';

$cardSet = CardSet\jassSet();
shuffle($cardSet);
Table\deal($cardSet, $players);

$hands = array_map(function(\Jass\Entity\Player $player) {
    return $player->hand;
}, $players);

/** @var \Jass\Entity\Player $human */
$human = $players[0];

$topDown = new \Jass\GameStyle\TopDown();
$bottumUp = new \Jass\GameStyle\BottomUp();

$styles = [$topDown, $bottumUp];
foreach (CardSet\suits() as $suit) {
    $styles[] = new \Jass\GameStyle\Trump($suit);
}

writeln("Your cards:");
foreach (Hand\ordered($human->hand, [$topDown, 'orderValue']) as $card) {
    writeln("* " . $card);
}

writeln("");

$n = 100;

$strategy = new \Jass\Strategy\Verrueren();

foreach ($styles as $style) {
    $sum = 0;
    foreach (range(1, $n) as $number) {
        // give all players the same card as shuffeled before
        array_walk($players, function(\Jass\Entity\Player $player, $i) use ($hands) {
            $player->hand = $hands[$i];
        });

        $player = $players[0];
        $playedTricks = [];
        while ($player->hand) {
            $trick = new Trick();

            while(!\Jass\Trick\isFinished($trick, $players)) {
                $card = $strategy->nextCard($style, $trick, $player);
                \Jass\Player\playTurn($trick, $player, $card);

                $player = $player->nextPlayer;
            }

            $player = \Jass\Trick\winner($trick, $style);
            $strategy->lookAtTrick($trick);

            $playedTricks[] = $trick;
        }

        $sum += $style->teamPoints($playedTricks, $human->team);
    }

    writeln("Average points when playing $n games of " . $style . ": " . ($sum / $n));

}


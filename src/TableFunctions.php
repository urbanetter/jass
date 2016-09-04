<?php

namespace Jass\Table;


use Jass\Entity\Card\Set;
use Jass\Entity\Team;
use Jass\Entity\Trick;
use Jass\GameStyle;

function deal(Set $set, $players)
{
    $cards = $set->cards;
    shuffle($cards);

    $playerNumber = 0;
    while (count($cards)) {
        $card = array_pop($cards);
        $players[$playerNumber]->hand[] = $card;
        $playerNumber = ($playerNumber < 3) ? $playerNumber + 1 : 0;
    }

    return $players;
}

function teamPoints(Team $team, $tricks, GameStyle $gameStyle)
{
    $tricks = array_filter($tricks, function(Trick $trick) use ($team, $gameStyle){
        return ($team == \Jass\Trick\winner($trick, $gameStyle)->team);
    });

    return array_sum(array_map(function(Trick $trick) use ($gameStyle) {
        return \Jass\Trick\points($trick, $gameStyle);
    }, $tricks));
}

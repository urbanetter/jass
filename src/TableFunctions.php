<?php

namespace Jass\Table;


use Jass\Entity\Team;
use Jass\Entity\Trick;
use Jass\GameStyle\GameStyle;

function deal($cards, $players)
{
    foreach ($players as $player) {
        $player->hand = [];
    }

    $player = $players[0];
    while (count($cards)) {
        $card = array_pop($cards);
        $player->hand[] = $card;
        $player = $player->nextPlayer;
    }

    return $players;
}

function teamPoints($tricks, Team $team, GameStyle $gameStyle)
{
    $tricks = array_filter($tricks, function(Trick $trick) use ($team, $gameStyle){
        return ($team == \Jass\Trick\winner($trick, $gameStyle)->team);
    });

    return array_sum(array_map(function(Trick $trick) use ($gameStyle) {
        return \Jass\Trick\points($trick, $gameStyle);
    }, $tricks));
}

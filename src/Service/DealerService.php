<?php

namespace Jass\Service;


class DealerService
{
    public function deal($set, $players)
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
}
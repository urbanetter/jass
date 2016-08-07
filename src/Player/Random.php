<?php

namespace Jass\Player;


use Jass\Entity\Player;
use Jass\Entity\Turn;
use Jass\Service\HandService;
use Jass\Service\PlayerService;

class Random
{
    /**
     * @param Player $player
     * @param Turn[] $turns
     */
    public function play($player, $turns)
    {
        $card = null;
        if (!$turns) {
            // first one to give a card
            $card = HandService::highest($player->hand);
        } else {
            $givenSuit = $turns[0]->card->suit;
            if (HandService::canFollowSuit($player->hand, $givenSuit)) {
                $card = HandService::highest(HandService::suit($player->hand, $givenSuit));
            } else {
                $card = HandService::lowest($player->hand);
            }
        }
        PlayerService::playCard($player, $card);

        $turn = new Turn();
        $turn->player = $player;
        $turn->card = $card;

        $turns[] = $turn;

        return $turns;
    }
}
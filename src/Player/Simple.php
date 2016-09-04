<?php

namespace Jass\Player;


use Jass\Entity\Player;
use Jass\Entity\Trick;
use Jass\GameStyle;
use Jass\Strategy;
use Jass\Hand;

class Simple extends Strategy
{
    public function nextCard(GameStyle $gameStyle, Trick $trick, Player $player)
    {
        if (!$trick->leadingSuit) {
            $card = Hand\highest($player->hand, [$gameStyle, 'orderValue']);
        } else {
            if (Hand\canFollowSuit($player->hand, $trick->leadingSuit)) {
                $card = Hand\highest(Hand\suit($player->hand, $trick->leadingSuit), [$gameStyle, 'orderValue']);
            } else {
                $card = Hand\lowest($player->hand, [$gameStyle, 'orderValue']);
            }
        }

        return $card;
    }
}
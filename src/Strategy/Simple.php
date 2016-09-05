<?php

namespace Jass\Strategy;


use Jass\Entity\Player;
use Jass\Entity\Trick;
use Jass\GameStyle\GameStyle;
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
                $bestTrickCard = Hand\highest(Hand\suit(\Jass\Trick\playedCards($trick), $trick->leadingSuit), [$gameStyle, 'orderValue']);
                if ($gameStyle->orderValue($bestTrickCard) > $gameStyle->orderValue($card)) {
                    $card =  Hand\lowest(Hand\suit($player->hand, $trick->leadingSuit), [$gameStyle, 'orderValue']);
                }
            } else {
                $card = Hand\lowest($player->hand, [$gameStyle, 'orderValue']);
            }
        }

        return $card;
    }
}
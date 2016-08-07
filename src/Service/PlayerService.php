<?php
namespace Jass\Service;


use Jass\Entity\Card;
use Jass\Entity\Player;

class PlayerService
{
    static public function playCard(Player $player, Card $card)
    {
        if (!in_array($card, $player->hand)) {
            throw new \InvalidArgumentException('Card not in hand!');
        }
        $index = array_search($card, $player->hand);
        unset($player->hand[$index]);

        return $player;
    }
}
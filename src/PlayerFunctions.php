<?php
namespace Jass\Player;


use Jass\Entity\Card;
use Jass\Entity\Player;
use Jass\Entity\Trick;
use Jass\Entity\Turn;

function playTurn(Trick $trick, Player $player, Card $card)
{
    if (!in_array($card, $player->hand)) {
        throw new \InvalidArgumentException('Card not in hand!');
    }

    $index = array_search($card, $player->hand);
    unset($player->hand[$index]);

    $turn = new Turn();
    $turn->player = $player;
    $turn->card = $card;

    if (!$trick->leadingSuit) {
        $trick->leadingSuit = $card->suit;
    }

    $trick->turns[] = $turn;
}

<?php

namespace Jass;


use Jass\Entity\Card;
use Jass\Entity\Player;
use Jass\Entity\Trick;

abstract class Strategy
{
    /**
     * @param GameStyle $gameStyle
     * @param Trick $trick
     * @param Player $player
     * @return Card next card the player plays
     */
    abstract public function nextCard(GameStyle $gameStyle, Trick $trick, Player $player);
}
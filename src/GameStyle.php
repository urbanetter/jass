<?php

namespace Jass;


use Jass\Entity\Card;
use Jass\Entity\Card\Suit;

abstract class GameStyle
{

    abstract public function orderValue(Card $card, Suit $leadingSuit = null);

    abstract public function beginningPlayer($players);

}
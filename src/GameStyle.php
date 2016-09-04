<?php

namespace Jass;


use Jass\Entity\Card;

abstract class GameStyle
{

    abstract public function orderValue(Card $card, $leadingSuit = null);

    abstract public function beginningPlayer($players);

    abstract public function points(Card $card);

}
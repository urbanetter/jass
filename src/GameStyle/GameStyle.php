<?php

namespace Jass\GameStyle;


use Jass\Entity\Card;
use Jass\Entity\Team;

abstract class GameStyle
{

    abstract public function orderValue(Card $card, $leadingSuit = null);

    abstract public function beginningPlayer($players);

    abstract public function points(Card $card);

    abstract public function teamPoints($tricks, Team $team);

}
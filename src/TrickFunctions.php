<?php

namespace Jass\Trick;

use Jass\Entity\Trick;
use Jass\GameStyle;

function isFinished(Trick $trick, $players)
{
    return count($trick->turns) == count($players);
}

function winner(Trick $trick, GameStyle $gameStyle)
{
    $winning = array_shift($trick->turns);
    foreach ($trick->turns as $candidate) {
        if ($gameStyle->orderValue($candidate->card) > $gameStyle->orderValue($winning->card)) {
            $winning = $candidate;
        }
    }
    return $winning->player;
}

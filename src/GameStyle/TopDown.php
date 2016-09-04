<?php

namespace Jass\GameStyle;


use Jass\Entity\Card;
use Jass\Entity\Card\Suit;
use Jass\Entity\Card\Value;
use Jass\GameStyle;

class TopDown extends GameStyle
{
    /**
     * @param Card $card
     * @param Suit $leadingSuit
     * @return int
     */
    public function orderValue(Card $card, Suit $leadingSuit = null)
    {
        $order = [Value::SIX, Value::SEVEN, Value::EIGHT, Value::NINE, Value::TEN, Value::JACK, Value::QUEEN, Value::KING, Value::ACE];
        $result = array_search($card->value, $order);

        // increase order if its the same suit like leading turn
        if ($leadingSuit && $leadingSuit == $card->suit) {
            $result += 100;
        }
        return $result;
    }

    public function beginningPlayer($players)
    {
        return $players[array_rand($players)];
    }

}
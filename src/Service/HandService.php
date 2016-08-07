<?php

namespace Jass\Service;


use Jass\Entity\Card;
use Jass\Entity\Value;

class HandService
{
    static public $defaultOrder = [Value::SIX, Value::SEVEN, Value::EIGHT, Value::NINE, Value::TEN, Value::JACK, Value::QUEEN, Value::KING, Value::ACE];

    /**
     * @param Card[] $hand
     * @param string $suit
     * @return Card[]
     */
    static public function suit($hand, $suit)
    {
        return array_filter($hand, function(Card $card) use ($suit){
            return $card->suit == $suit;
        });
    }

    /**
     * @param Card[] $hand
     * @param Card $suit
     * @return bool
     */
    static public function canFollowSuit($hand, $suit)
    {
        return count(HandService::suit($hand, $suit)) > 0;
    }

    /**
     * @param Card[] $hand
     * @return Card
     */
    static public function lowest($hand)
    {
        return array_reduce($hand, function($lowest, $card) {
            if (!$lowest || HandService::orderValue($card) < HandService::orderValue($lowest)) {
                return $card;
            } else {
                return $lowest;
            }
        });
    }

    /**
     * @param Card[] $hand
     * @return Card
     */
    static public function highest($hand)
    {
        return array_reduce($hand, function($highest, $card) {
            if (!$highest || HandService::orderValue($card) > HandService::orderValue($highest)) {
                return $card;
            } else {
                return $highest;
            }
        });
    }

    /**
     * @param Card $card
     * @return int
     */
    static public function orderValue(Card $card)
    {
        return array_search($card->value, HandService::$defaultOrder);
    }


}
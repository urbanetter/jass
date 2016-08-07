<?php

namespace Jass\Service;


use Jass\Entity\Card;
use Jass\Entity\Set;
use Jass\Entity\Suit;
use Jass\Entity\Value;

class SetService
{
    static public function getJassSet()
    {
        $suits = [Suit::ROSE, Suit::BELL, Suit::OAK, Suit::SHIELD];
        $values = [Value::SIX, Value::SEVEN, Value::EIGHT, Value::NINE, Value::TEN, Value::JACK, Value::QUEEN, Value::KING, Value::ACE];

        return SetService::getSetBySuitsAndValues($suits, $values);
    }

    static public function getTestSet()
    {
        $suits = [Suit::ROSE, Suit::BELL, Suit::OAK, Suit::SHIELD];
        $values = [Value::KING, Value::ACE];

        return SetService::getSetBySuitsAndValues($suits, $values);
    }

    static public function getSetBySuitsAndValues($suits, $values)
    {
        $set = new Set();
        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $card = new Card();
                $card->suit = $suit;
                $card->value = $value;

                $set->cards[] = $card;
            }
        }

        return $set;
    }
}
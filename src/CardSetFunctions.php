<?php

namespace Jass\CardSet;


use Jass\Entity\Card;
use Jass\Entity\Card\Set;
use Jass\Entity\Card\Suit;
use Jass\Entity\Card\Value;

function jassSet()
{
    $suits = [Suit::ROSE, Suit::BELL, Suit::OAK, Suit::SHIELD];
    $values = [Value::SIX, Value::SEVEN, Value::EIGHT, Value::NINE, Value::TEN, Value::JACK, Value::QUEEN, Value::KING, Value::ACE];

    return bySuitsAndValues($suits, $values);
}

function testSet()
{
    $suits = [Suit::ROSE, Suit::BELL, Suit::OAK, Suit::SHIELD];
    $values = [Value::KING, Value::ACE];

    return bySuitsAndValues($suits, $values);
}

function bySuitsAndValues($suits, $values)
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
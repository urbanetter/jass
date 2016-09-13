<?php

namespace Jass\CardSet;


use Jass\Entity\Card;
use Jass\Entity\Card\Suit;
use Jass\Entity\Card\Value;
use Jass\Hand;

function jassSet()
{
    $suits = suits();
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
    $cards = [];
    foreach ($suits as $suit) {
        foreach ($values as $value) {
            $card = new Card();
            $card->suit = $suit;
            $card->value = $value;

            $cards[] = $card;
        }
    }

    return $cards;
}

function suits($hand = null)
{
    $suits = [Suit::ROSE, Suit::BELL, Suit::OAK, Suit::SHIELD];
    if (is_null($hand)) {
        return $suits;
    } else {
        return array_filter($suits, function($suit) use ($hand) {
            return count(Hand\suit($hand, $suit));
        });
    }
}

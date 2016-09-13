<?php

namespace Jass\Hand;


use Jass\Entity\Card;
use Jass\CardSet;

/**
 * @param Card[] $hand
 * @param string $suit
 * @return Card[]
 */
function suit($hand, $suit)
{
    return array_filter($hand, function(Card $card) use ($suit){
        return $card->suit == $suit;
    });
}

/**
 * @param Card[] $hand
 * @param string $suit
 * @return bool
 */
function canFollowSuit($hand, $suit)
{
    return count(suit($hand, $suit)) > 0;
}

/**
 * @param Card[] $hand
 * @param Callable $orderFunction
 * @return Card
 */
function lowest($hand, $orderFunction)
{
    return array_reduce($hand, function($lowest, $card) use ($orderFunction) {
        if (!$lowest || $orderFunction($card) < $orderFunction($lowest)) {
            return $card;
        } else {
            return $lowest;
        }
    });
}

/**
 * @param Card[] $hand
 * @param Callable $orderFunction
 * @return Card
 */
function highest($hand, $orderFunction)
{
    return array_reduce($hand, function($highest, $card) use ($orderFunction) {
        if (!$highest || $orderFunction($card) > $orderFunction($highest)) {
            return $card;
        } else {
            return $highest;
        }
    });
}

/**
 * @param Card[] $hand
 * @param Callable $orderFunction
 * @return Card[]
 */
function ordered($hand, $orderFunction)
{
    $suits = CardSet\suits($hand);
    $result = [];
    foreach ($suits as $suit) {
        $cards = suit($hand, $suit);
        usort($cards, function ($a, $b) use ($orderFunction) {
            return $orderFunction($b) <=> $orderFunction($a);
        });
        $result = array_merge($result, $cards);
    }

    return $result;
}

/**
 * @param Card[] $playedCards
 * @param string $suit
 * @param Callable $orderFunction
 * @return Card
 */
function bock($playedCards, $suit, $orderFunction)
{
    $playedSuit = suit($playedCards, $suit);
    $fullSuit = suit(CardSet\jassSet(), $suit);

    $unplayed = array_diff($fullSuit, $playedSuit);
    return highest($unplayed, $orderFunction);
}

/**
 * @param Card[] $playedCards
 * @param Card[] $hand
 * @param string $suit
 * @param Callable $orderFunction
 * @return int
 */
function potential($playedCards, $hand, $suit, $orderFunction)
{
    $cards = suit($hand, $suit);

    if (!count($cards)) {
        return 0;
    }

    $neededCards = 0;

    while (bock($playedCards, $suit, $orderFunction) && !in_array(bock($playedCards, $suit, $orderFunction), $cards) && $neededCards < count($cards)) {
        $playedCards[] = bock($playedCards, $suit, $orderFunction);
        $neededCards++;
    }

    $potential = 0;
    if ($neededCards < count($cards)) {
        $potential += (10 - $neededCards);
    }
    $potential = ($potential * 10) + count($cards);

    return $potential;

}

function bestSuit($playedCards, $hand, $orderFunction)
{
    $suits = CardSet\suits();
    $bestSuit = array_reduce($suits, function($best, $suit) use ($playedCards, $hand, $orderFunction) {
        $suitScore = potential($playedCards, $hand, $suit, $orderFunction);
        if (!$best) {
            return $suit;
        }
        if ($suitScore > potential($playedCards, $hand, $best, $orderFunction)) {
            return $suit;
        } else {
            return $best;
        }
    });

    return $bestSuit;
}

function worstSuit($playedCards, $hand, $orderFunction)
{
    $suits = CardSet\suits();
    $suits = array_filter($suits, function($suit) use ($hand) {
        return count(suit($hand, $suit));
    });
    $worstSuit = array_reduce($suits, function($worst, $suit) use ($playedCards, $hand, $orderFunction) {
        $suitScore = potential($playedCards, $hand, $suit, $orderFunction);
        if (!$worst) {
            return $suit;
        }
        if ($suitScore < potential($playedCards, $hand, $worst, $orderFunction)) {
            return $suit;
        } else {
            return $worst;
        }
    });

    return $worstSuit;
}

function first($array)
{
    return array_slice($array, 0, 1)[0];
}

function last($array)
{
    return array_slice($array, -1)[0];
}

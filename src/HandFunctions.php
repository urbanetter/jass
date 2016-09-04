<?php

namespace Jass\Hand;


use Jass\Entity\Card;

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

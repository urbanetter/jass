<?php

namespace Jass\Game;


use Jass\Entity\Turn;
use Jass\Entity\Value;

class TopDown
{
    private $givenSuit;

    private $order = [Value::SIX, Value::SEVEN, Value::EIGHT, Value::NINE, Value::TEN, Value::JACK, Value::QUEEN, Value::KING, Value::ACE];

    /**
     * @param Turn[] $turns
     * @return Turn
     */
    public function getWinningTurn($turns)
    {
        $this->givenSuit = $turns[0]->card->suit;

        $winner = array_shift($turns);
        foreach ($turns as $turn) {
            $winner = $this->challengeWinner($winner, $turn);
        }
        return $winner;

    }

    /**
     * @param Turn $winner
     * @param Turn $challenger
     * @return Turn
     */
    public function challengeWinner($winner, $challenger)
    {
        if ($challenger->card->suit != $this->givenSuit) {
            return $winner;
        }

        $winnerOrder = array_search($winner->card->value, $this->order);
        $challengerOrder = array_search($challenger->card->value, $this->order);

        return ($challengerOrder > $winnerOrder) ? $challenger : $winner;
    }
}
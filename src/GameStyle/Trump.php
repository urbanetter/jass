<?php
namespace Jass\GameStyle;


use Jass\Entity\Card;
use Jass\Entity\Card\Value;

class Trump extends TopDown
{
    public $trumpSuit;

    /**
     * Trump constructor.
     * @param $trumpSuit
     */
    public function __construct($trumpSuit)
    {
        $this->trumpSuit = $trumpSuit;
    }


    public function orderValue(Card $card, $leadingSuit = null)
    {
        if ($card->suit == $this->trumpSuit) {
            $order = [Value::SIX, Value::SEVEN, Value::EIGHT, Value::TEN, Value::QUEEN, Value::KING, Value::ACE, Value::NINE, Value::JACK];
        } else {
            $order = $this->order();
        }

        $result = array_search($card->value, $order);

        // increase value if its the same suit like leading turn
        if ($leadingSuit && $leadingSuit == $card->suit) {
            $result += 100;
        }

        // increase value if its trump
        if ($this->trumpSuit == $card->suit) {
            $result += 200;
        }

        return $result;

    }

    public function points(Card $card)
    {
        if ($this->trumpSuit == $card->suit) {
            $points = [Value::JACK => 20, Value::NINE => 14, Value::TEN => 10, Value::QUEEN => 3, Value::KING => 4, Value::ACE => 11];
        } else {
            $points = [Value::TEN => 10, Value::JACK => 2, Value::QUEEN => 3, Value::KING => 4, Value::ACE => 11];
        }

        return isset($points[$card->value]) ? $points[$card->value] : 0;
    }

    public function name()
    {
        return $this->trumpSuit . " Trumpf";
    }

}
<?php

namespace Jass\Entity;

class Card
{
    /**
     * @var string
     */
    public $suit;

    /**
     * @var string
     */
    public $value;

    public function __toString()
    {
        return $this->suit . " " . $this->value;
    }
}
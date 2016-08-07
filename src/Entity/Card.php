<?php

namespace Jass\Entity;

class Card
{
    public $suit;
    public $value;

    public function __toString()
    {
        return $this->suit . " " . $this->value;
    }
}
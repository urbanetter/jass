<?php

namespace Jass\Entity;

class Player
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var Card[]
     */
    public $hand;


    public function __toString()
    {
        return $this->name;
    }
}
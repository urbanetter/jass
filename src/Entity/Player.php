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

    /**
     * @var Team
     */
    public $team;

    /**
     * @var Player
     */
    public $nextPlayer;

    /**
     * @var array
     */
    public $brain;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
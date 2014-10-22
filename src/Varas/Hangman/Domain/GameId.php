<?php

namespace Varas\Hangman\Domain;

/**
 * Identity value object for the Game entity
 */
class GameId
{
    private $value;

    public function __construct()
    {
        return $this->value = uniqid();
    }

    /**
     * @return string   Game identifier
     */
    public function getValue()
    {
        return $this->value;
    }
}

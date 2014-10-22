<?php

namespace Varas\Hangman\Domain;

class Guess
{
    private $letter;

    /**
     * @param string $letter
     */
    public function __construct($letter)
    {
        if (preg_match('/^[a-z]$/',$letter) !== 1) {
            throw new \InvalidArgumentException;
        }

        $this->letter = $letter;
    }

    /**
     * @return string
     */
    public function getLetter()
    {
        return $this->letter;
    }
}

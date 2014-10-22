<?php

namespace Varas\Hangman\Domain;

class Word
{
    private $value;

    /**
     * @param string Word
     */
    public function __construct($value)
    {
        if (!ctype_alpha($value)) {
            throw new \InvalidArgumentException('Invalid value for word: '.$value);
        }
        $this->value = $value;
    }

    /**
     * @return string Valid word, only alphabetic characters
     */
    public function getValue()
    {
        return $this->value;
    }
}

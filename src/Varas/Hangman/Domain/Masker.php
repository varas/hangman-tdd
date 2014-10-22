<?php

namespace Varas\Hangman\Domain;

class Masker
{
    const MASK = '.';

    /**
     * @param Word $word        Word to mask
     * @param array $guesses    Guesses containing letters to unmask
     * @return string           Masked word representation
     */
    public function mask(Word $word, array $guesses)
    {
        $mask = strtoupper($word->getValue());

        foreach($guesses as $guess) {
            if (! $guess instanceof Guess) {
                throw new \InvalidArgumentException('Invalid guess');
            }
                
            $letter = $guess->getLetter();
            $mask = str_replace(strtoupper($letter), $letter, $mask);
        }

        return preg_replace("/[A-Z]/", self::MASK, $mask);
    }
}

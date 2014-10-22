<?php

namespace Varas\Hangman\Domain;

/**
 * Word repository specification
 */
interface WordRepository
{
    /**
     * @return Word Random word to be guessed 
     */
    public function getRandomWord();
}

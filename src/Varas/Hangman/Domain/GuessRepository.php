<?php

namespace Varas\Hangman\Domain;

/**
 * Guess repository specification
 */
interface GuessRepository
{
    /**
     * @param \Varas\Hangman\Domain\GameId  $gameId Game identifier 
     * @return \Varas\Hangman\Domain\Guess[]        Guess for the provided GameId
     */
    public function fetch(GameId $gameId);

    /**
     * @param \Varas\Hangman\Domain\GameId  $gameId Game identifier
     * @param \Varas\Hangman\Domain\Guess   $guess  Guess to store
     */
    public function store(GameId $gameId, Guess $guess);
}

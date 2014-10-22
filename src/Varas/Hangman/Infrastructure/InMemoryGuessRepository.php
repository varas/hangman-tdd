<?php

namespace Varas\Hangman\Infrastructure;

use Varas\Hangman\Domain\Guess;
use Varas\Hangman\Domain\GameId;
use Varas\Hangman\Domain\GuessRepository;

/**
 * In memory guess repository
 */
class InMemoryGuessRepository implements GuessRepository
{
    private $guesses;

    public function __construct()
    {
        $this->guesses = [];
    }

    /**
     * @param \Varas\Hangman\Domain\GameId  $gameId Game identifier
     * @return \Varas\Hangman\Domain\Guess[]        Guess for the provided GameId
     */
    public function fetch(GameId $gameId)
    {
        $gameIdValue = $gameId->getValue();

        if (!array_key_exists($gameIdValue, $this->guesses))
            return;

        return $this->guesses[$gameId->getValue()];
    }

    /**
     * @param \Varas\Hangman\Domain\GameId  $gameId Game identifier
     * @param \Varas\Hangman\Domain\Guess   $guess  Guess to store
     */
    public function store(GameId $gameId, Guess $guess)
    {
        $this->guesses[$gameId->getValue()] = $guess;
    }
}

<?php

namespace Varas\Hangman\Domain;

/**
 * Game repository specification
 */
interface GameRepository
{

    /**
     * Generate a new game and returns its Id
     *
     * @param \Varas\Hangman\Domain\Word            $word               Word to be guessed
     * @param \Varas\Hangman\Domain\GuessRepository $guessRepository    Guess repository
     * @return \Varas\Hangman\Domain\GameId         Unique id generated
     */
    public function create(Word $word, GuessRepository $guessRepository);

    /**
     * @return Game[]   Retrieves current games 
     */
    public function findAll();

    /**
     * @param \Varas\Hangman\Domain\GameId  $gameId
     * @return \Varas\Hangman\Domain\Game   Game for the provided id
     */
    public function findById(GameId $gameId);

    /**
     * @param \Varas\Hangman\Domain\Game $game Game to store
     */
    public function store(Game $game);
}

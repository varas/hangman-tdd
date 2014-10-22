<?php

namespace Varas\Hangman\Infrastructure;

use Varas\Hangman\Domain\Word;
use Varas\Hangman\Domain\GuessRepository;
use Varas\Hangman\Domain\Game;
use Varas\Hangman\Domain\GameId;
use Varas\Hangman\Domain\GameRepository;

/**
 * In memory game repository
 */
class InMemoryGameRepository implements GameRepository
{
    private $games;

    public function __construct()
    {
        $this->games = [];
    }

    /**
     * Generate a new game and returns its Id
     *
     * @param \Varas\Hangman\Domain\Word    $word   Word to be guessed
     * @param \Varas\Hangman\Domain\GuessRepository $guessRepository Storage for the guesses made
     * @return \Varas\Hangman\Domain\GameId         Unique id generated
     */
    public function create(Word $word, GuessRepository $guessRepository)
    {
        $game = new Game($word, $guessRepository);
        $this->store($game);
    }

    /**
     * @return Game[]   Retrieves current games
     */
    public function findAll()
    {
        return $this->games;
    }

    /**
     * @param \Varas\Hangman\Domain\GameId  $gameId
     * @return \Varas\Hangman\Domain\Game   Game for the provided id
     */
    public function findById(GameId $gameId)
    {
        return $this->games[$gameId->getValue()];
    }

    /**
     * @param \Varas\Hangman\Domain\Game $game Game to store
     */
    public function store(Game $game)
    {
        $gameId = $game->getId();

        if (! $gameId instanceof GameId)
            throw new \Exception('Game does not contains valid game id');

        $this->games[$gameId->getValue()] = $game;
    }
}

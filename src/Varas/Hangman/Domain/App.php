<?php

namespace Varas\Hangman\Domain;

use Varas\Hangman\Domain\GameRepository;
use Varas\Hangman\Domain\WordRepository;
use Varas\Hangman\Domain\GuessRepository;

/**
 * Application
 *
 * Game manager.
 */
class App
{
    private $gameRepository;
    private $wordRepository;
    private $guessRepository;

    /**
     * @param \Varas\Hangman\Domain\GameRepository $gameRepository      Game repository
     * @param \Varas\Hangman\Domain\WordRepository $wordRepository      Word repository
     * @param \Varas\Hangman\Domain\GuessRepository $guessRepository    Guess repository
     */
    public function __construct(GameRepository $gameRepository,
                                WordRepository $wordRepository,
                                GuessRepository $guessRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->wordRepository = $wordRepository;
        $this->guessRepository = $guessRepository;
    }

    /**
     * @return \Varas\Hangman\Domain\GameId   Game Id
     */
    public function startGame()
    {
        $word = $this->wordRepository->getRandomWord();
        return $this->gameRepository->create($word, $this->guessRepository);
    }

    /**
     * @return \Varas\Hangman\Domain\Game[]   Current games
     */
    public function getGames()
    {
        return $this->gameRepository->findAll();
    }

    /**
     * @param \Varas\Hangman\Domain\GameId  $gameId
     * @return \Varas\Hangman\Domain\Game   Game for the provided id
     */
    public function findGameById(GameId $gameId)
    {
        return $this->gameRepository->findById($gameId);
    }

    /**
     * @param \Varas\Hangman\Domain\Game    $game   Game subject of the guess
     * @param \Varas\Hangman\Domain\Guess   $guess  Guess made
     */
    public function makeGuess(Game $game, Guess $guess)
    {
        $game->guess($guess);
        $this->gameRepository->store($game);
    }
}

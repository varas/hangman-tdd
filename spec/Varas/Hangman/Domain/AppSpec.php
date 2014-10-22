<?php

namespace spec\Varas\Hangman\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Varas\Hangman\Domain\Game;
use Varas\Hangman\Domain\GameId;
use Varas\Hangman\Domain\GameRepository;
use Varas\Hangman\Domain\Guess;
use Varas\Hangman\Domain\GuessRepository;
use Varas\Hangman\Domain\Word;
use Varas\Hangman\Domain\WordRepository;

class AppSpec extends ObjectBehavior
{

    public function let(GameRepository $gameRepository, WordRepository $wordRepository, GuessRepository $guessRepository)
    {
        $this->beConstructedWith($gameRepository, $wordRepository, $guessRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Varas\Hangman\Domain\App');
    }

    function it_starts_new_games(GameRepository $gameRepository, WordRepository $wordRepository, Word $word, Game $game, GuessRepository $guessRepository)
    {
        $wordRepository->getRandomWord()->shouldBeCalled()->willReturn($word);
        $gameRepository->create($word, $guessRepository)->shouldBeCalled()->willReturn($game);
        $this->startGame()->shouldReturnAnInstanceOf('\Varas\Hangman\Domain\Game');
    }

    function it_returns_current_games(GameRepository $gameRepository, Game $game)
    {
        $gameRepository->findAll()->shouldBeCalled()->willReturn(array($game, $game));
        $this->getGames()->shouldHaveCount(2);
    }

    function it_returns_the_game_for_a_gameid(GameRepository $gameRepository, GameId $gameId, Game $game)
    {
        $gameRepository->findById($gameId)->shouldBeCalled()->willReturn($game);
        $this->findGameById($gameId)->shouldReturnAnInstanceOf('\Varas\Hangman\Domain\Game');
    }

    function it_makes_a_guess_for_a_game(GameRepository $gameRepository, Game $game, Game $game, Guess $guess)
    {
        $game->guess($guess)->shouldBeCalled();
        $gameRepository->store($game)->shouldBeCalled();
        $this->makeGuess($game, $guess);
    }
}

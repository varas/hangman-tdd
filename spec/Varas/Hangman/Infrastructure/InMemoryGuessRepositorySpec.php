<?php

namespace spec\Varas\Hangman\Infrastructure;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Varas\Hangman\Domain\Guess;
use Varas\Hangman\Domain\GameId;

class InMemoryGuessRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Varas\Hangman\Infrastructure\InMemoryGuessRepository');
    }

    function it_stores_a_guess_for_a_game_identifier(GameId $gameId, Guess $guess)
    {
        $guesses= $this->fetch($gameId);
        $this->fetch($gameId)->shouldBe($guesses);
    }

    function it_returns_guesses_stored_for_a_game_identifier(GameId $gameId, Guess $guess)
    {
        $guessesBeforeStore = $this->fetch($gameId);
        $this->store($gameId, $guess);
        $this->fetch($gameId)->shouldNotBe($guessesBeforeStore);
    }
}

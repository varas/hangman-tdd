<?php

namespace spec\Varas\Hangman\Infrastructure;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Varas\Hangman\Domain\Word;
use Varas\Hangman\Domain\GuessRepository;
use Varas\Hangman\Domain\Game;
use Varas\Hangman\Domain\GameId;

class InMemoryGameRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Varas\Hangman\Infrastructure\InMemoryGameRepository');
    }

    function it_returns_all_games_list()
    {
        $this->findAll()->shouldBeArray();
    }

    function it_stores_a_game(Game $game, GameId $gameId)
    {
        $gamesBeforeStore = $this->findAll();
        $game->getId()->willReturn($gameId);
        $this->store($game);
        $this->findAll()->shouldNotBe($gamesBeforeStore);
    }

    function it_stores_a_game_on_create(Word $word, GuessRepository $guessRepository)
    {
        $gamesBeforeCreate = $this->findAll();
        $this->create($word, $guessRepository);
        $this->findAll()->shouldNotBe($gamesBeforeCreate);
    }

    function it_throws_exception_if_not_gameid_present_when_storing(Game $game, \StdClass $invalidGameIdClass)
    {
        $game->getId()->willReturn($invalidGameIdClass);
        $this->shouldThrow('Exception')->during('store', [$game]);
    }

    function it_finds_a_game_by_its_identifier(Game $game, GameId $gameId)
    {
        $game->getId()->willReturn($gameId);
        $this->store($game);
        $this->findById($gameId)->shouldBe($game);
    }
}

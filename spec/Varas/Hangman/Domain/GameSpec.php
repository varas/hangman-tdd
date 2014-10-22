<?php

namespace spec\Varas\Hangman\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Varas\Hangman\Domain\Guess;
use Varas\Hangman\Domain\GuessRepository;
use Varas\Hangman\Domain\Word;
use Varas\Hangman\Domain\WordRepository;
use Varas\Hangman\Domain\GameId;

class GameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Varas\Hangman\Domain\Game');
    }

    function let(Word $word, GuessRepository $guessRepository)
    {
        $this->beConstructedWith($word, $guessRepository);
    }

    function it_returns_tries_left()
    {
        $this->getTriesLeft()->shouldBeInteger();
    }

    function it_returns_11_tries_left_at_start()
    {
        $this->getTriesLeft()->shouldBe(11);
    }

    function it_returns_10_tries_left_after_a_guess(Guess $guess)
    {
        $this->guess($guess);
        $this->getTriesLeft()->shouldBe(10);
    }

    function it_returns_9_tries_left_after_two_guesses(Guess $guess)
    {
        $this->guess($guess);
        $this->guess($guess);
        $this->getTriesLeft()->shouldBe(9);
    }

    function it_returns_the_full_mask_for_foo_at_start(GuessRepository $guessRepository)
    {
        $this->beConstructedWith(new Word('foo'), $guessRepository);
        $guessRepository->fetch(Argument::any())->willReturn([]);
        $this->getWord()->shouldBe('...');
    }

    function it_returns_the_full_mask_for_foobar_at_start(GuessRepository $guessRepository)
    {
        $this->beConstructedWith(new Word('foobar'), $guessRepository);
        $guessRepository->fetch(Argument::any())->willReturn([]);
        $this->getWord()->shouldBe('......');
    }

    function it_returns_unmasked_chars_for_guessed_letter(GuessRepository $guessRepository)
    {
        $this->beConstructedWith(new Word('foobar'), $guessRepository);
        $guessRepository->fetch(Argument::any())->willReturn([new Guess('a')]);
        $this->getWord()->shouldBe('....a.');
    }

    function it_returns_unmasked_chars_for_guessed_letter_for_all_the_letter_appearances(GuessRepository $guessRepository)
    {
        $this->beConstructedWith(new Word('foobar'), $guessRepository);
        $guessRepository->fetch(Argument::any())->willReturn([new Guess('o')]);
        $this->getWord()->shouldBe('.oo...');
    }

    function it_returns_unmasked_chars_for_every_guessed_letter(GuessRepository $guessRepository)
    {
        $this->beConstructedWith(new Word('foobar'), $guessRepository);
        $guesses = [
            new Guess('f'),
            new Guess('o')];
        $guessRepository->fetch(Argument::any())->willReturn($guesses);
        $this->getWord()->shouldBe('foo...');
    }

    function it_returns_a_status_string(GuessRepository $guessRepository)
    {
        $guessRepository->fetch(Argument::any())->willReturn([]);
        $this->getStatus()->shouldBeString();
    }

    function it_returns_busy_status_before_any_guess(GuessRepository $guessRepository)
    {
        $guessRepository->fetch(Argument::any())->willReturn([]);
        $this->beConstructedWith(new Word('foo'), $guessRepository);
        $this->getStatus()->shouldBe('busy');
    }

    function it_returns_busy_status_while_tries_left(GuessRepository $guessRepository)
    {
        $this->beConstructedWith(new Word('foobar'), $guessRepository);
        $guessRepository->fetch(Argument::any())->willReturn([new Guess('o')]);
        $this->getStatus()->shouldBe('busy');
    }

    function it_returns_fail_status_if_no_tries_left_and_not_all_chars_has_been_guessed(GuessRepository $guessRepository)
    {
        $this->beConstructedWith(new Word('foo'), $guessRepository);
        $guessesMade = [];
        $elevenFailingLetters = str_split('abcdeghijkl');
        foreach($elevenFailingLetters as $letter) {
            $guess = new Guess($letter);
            $guessesMade[] = $guess;
            $this->guess($guess);
        }
        $guessRepository->fetch(Argument::any())->willReturn($guessesMade);
        $this->getStatus()->shouldBe('fail');
    }

    function it_returns_success_status_if_all_chars_has_been_guessed_in_less_than_11_tries(GuessRepository $guessRepository)
    {
        $this->beConstructedWith(new Word('foo'), $guessRepository);
        $guessesMade = [
            new Guess('f'),
            new Guess('o')];
        foreach ($guessesMade as $guess) {
            $this->guess($guess);
        }
        $guessRepository->fetch(Argument::any())->willReturn($guessesMade);
        $this->getStatus()->shouldBe('success');
    }

    function it_returns_success_status_if_all_chars_has_been_guessed_in_11_tries(GuessRepository $guessRepository)
    {
        $this->beConstructedWith(new Word('foo'), $guessRepository);
        $guessesMade = [];
        $elevenSuccessLetters = str_split('abcdeghijfo');
        foreach($elevenSuccessLetters as $letter) {
            $guess = new Guess($letter);
            $guessesMade[] = $guess;
            $this->guess($guess);
        }
        $guessRepository->fetch(Argument::any())->willReturn($guessesMade);
        $this->getStatus()->shouldBe('success');
    }

    function it_does_not_decrement_tries_for_correct_guess(GuessRepository $guessRepository)
    {
        $this->beConstructedWith(new Word('foobar'), $guessRepository);
        $this->guess(new Guess('o'));
        $this->getTriesLeft()->shouldBe(11);
    }

    function it_stores_guesses_in_repository(Guess $guess, GuessRepository $guessRepository)
    {
        $guessRepository->store(Argument::any(), $guess)->shouldBeCalled();
        $this->guess($guess);
    }
}

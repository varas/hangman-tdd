<?php

namespace spec\Varas\Hangman\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Varas\Hangman\Domain\Word;

class MaskerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Varas\Hangman\Domain\Masker');
    }

    function it_turns_a_word_to_a_masked_string_given_some_guesses(Word $word)
    {
        $this->mask($word, $guesses = [])->shouldBeString();
    }
}

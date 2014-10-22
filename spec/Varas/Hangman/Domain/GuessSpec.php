<?php

namespace spec\Varas\Hangman\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GuessSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith($aValidLetter = 'a');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Varas\Hangman\Domain\Guess');
    }

    function it_cannot_contain_more_than_one_letter()
    {
        $this->shouldThrow('InvalidArgumentException')->during('__construct',['aa']);
    }

    function it_cannot_contain_uppercase()
    {
        $this->shouldThrow('InvalidArgumentException')->during('__construct',['A']);
    }

    function it_can_only_contain_valid_characters_a_to_z()
    {
        $invalidCharacters = str_split('1234567890/-_.,;');
        foreach($invalidCharacters as $invalidCharacter) {
            $this->shouldThrow('InvalidArgumentException')->during('__construct',[$invalidCharacter]);
        }
    }

    function it_returns_a_valid_letter()
    {
        $validLetter = $this->getLetter();
        $this->shouldNotThrow('InvalidArgumentException')->during('__construct',[$validLetter]);
    }
}

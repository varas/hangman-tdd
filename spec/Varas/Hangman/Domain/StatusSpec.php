<?php

namespace spec\Varas\Hangman\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StatusSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith($numberOfTriesLeft = 11, $hasBeenGuessed = false);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Varas\Hangman\Domain\Status');
    }

    function it_can_be_parsed_to_string()
    {
        $this->__toString()->shouldBeString();
    }

    function it_defaults_to_busy()
    {
        $this->__toString()->shouldBe('busy');
    }

    function it_depends_on_the_number_of_tries_left_and_if_word_has_been_guessed_word()
    {
        $numberOfTriesLeft = 0;
        $hasBeenGuessed = true;
        $this->shouldNotThrow('InvalidArgumentException')->during('__construct',[$numberOfTriesLeft, $hasBeenGuessed]);
    }

    function its_number_of_tries_left_must_be_integer()
    {
        $hasBeenGuessed = true;

        $numberOfTriesLeft = 0.5;
        $this->shouldThrow('InvalidArgumentException')->during('__construct',[$numberOfTriesLeft, $hasBeenGuessed]);
        $numberOfTriesLeft = 'a';
        $this->shouldThrow('InvalidArgumentException')->during('__construct',[$numberOfTriesLeft, $hasBeenGuessed]);
        $numberOfTriesLeft = array();
        $this->shouldThrow('InvalidArgumentException')->during('__construct',[$numberOfTriesLeft, $hasBeenGuessed]);
        $numberOfTriesLeft = new \StdClass();
        $this->shouldThrow('InvalidArgumentException')->during('__construct',[$numberOfTriesLeft, $hasBeenGuessed]);
    }
}

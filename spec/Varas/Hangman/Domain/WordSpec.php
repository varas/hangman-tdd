<?php

namespace spec\Varas\Hangman\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WordSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith($validWord = 'foo');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Varas\Hangman\Domain\Word');
    }

    function it_returns_its_value()
    {
        $this->getValue()->shouldBeString();
    }

    function it_is_created_by_letters()
    {
        $this->shouldNotThrow('InvalidArgumentException')->during('__construct',['foo']);
    }

    function it_cannot_be_created_by_numbers()
    {
        $this->shouldThrow('InvalidArgumentException')->during('__construct',['foo1']);
    }
}

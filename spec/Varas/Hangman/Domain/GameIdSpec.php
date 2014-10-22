<?php

namespace spec\Varas\Hangman\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GameIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Varas\Hangman\Domain\GameId');
    }

    function it_returns_its_value()
    {
        $this->getValue()->shouldBeString();
    }
}

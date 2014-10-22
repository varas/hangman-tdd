<?php

namespace spec\Varas\Hangman\Infrastructure;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileWordRepositorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith($filePath = __DIR__.'/../../../../words.english');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Varas\Hangman\Infrastructure\FileWordRepository');
    }

    function it_throws_exception_if_invalid_file()
    {
        $this->shouldThrow('InvalidArgumentException')->during('__construct',['invalid/file/path']);
    }

    function it_returns_a_random_word()
    {
        $this->getRandomWord()->shouldHaveType('Varas\Hangman\Domain\Word');
    }
}

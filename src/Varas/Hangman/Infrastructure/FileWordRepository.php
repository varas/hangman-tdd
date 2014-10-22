<?php

namespace Varas\Hangman\Infrastructure;

use Varas\Hangman\Domain\WordRepository;
use Varas\Hangman\Domain\Word;

class FileWordRepository implements WordRepository
{

    private $words;

    public function __construct($filePath)
    {
        if (!file_exists($filePath) or is_dir($filePath)) {
            throw new \InvalidArgumentException('Invalid file path: '.$filePath);
        }
        $this->words = file($filePath);

        $removeLineFeed = function($strWord) {
            return str_replace(["\n", "\r"], '', $strWord);
        };
        $this->words = array_map($removeLineFeed, $this->words);
    }

    /**
     * @return Word Random word to be guessed
     */
    public function getRandomWord()
    {
        $strWord = $this->words[array_rand($this->words)];
        return new Word($strWord);
    }
}

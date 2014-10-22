<?php

namespace Varas\Hangman\Domain;

/**
 * Game entity
 */
class Game
{
    private $id;
    private $word;
    private $triesLeft;
    private $guessRepository;
    private $masker;

    /**
     * @param \Varas\Hangman\Domain\Word $word Word to be guessed
     * @param \Varas\Hangman\Domain\GuessRepository $guessRepository Storage for the guesses made
     */
    public function __construct(Word $word, GuessRepository $guessRepository)
    {
        $this->id = new GameId();
        $this->word = $word;
        $this->triesLeft = 11;
        $this->guessRepository = $guessRepository;
        $this->masker = new Masker();
    }

    /**
     * @return \Varas\Hangman\Domain\GameId   Game Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Guess $guess  Guess to apply
     */
    public function guess(Guess $guess)
    {
        $this->guessRepository->store($this->id, $guess);

        if ( strpos($this->word->getValue(), $guess->getLetter()) === false ) {
            $this->triesLeft--;
        }
    }

    /**
     * @return int  Number of tries left
     */
    public function getTriesLeft()
    {
        return $this->triesLeft;
    }

    /**
     * @return string   Representation of the word that is being guessed. 
     *                  Should contain dots for letters that have not been 
     *                  guessed yet (e.g. aw.so..)
     */
    public function getWord()
    {
        $guesses = $this->getGuesses();

        return $this->masker->mask($this->word, $guesses);
    }

    private function getGuesses()
    {
        return $this->guessRepository->fetch($this->id);
    }

    /**
     * @return string   Game status
     */
    public function getStatus()
    {
        $status = new Status($this->triesLeft, $this->hasBeenGuessed());

        return (string)$status;
    }

    /**
     * @return bool True if word has been guessed already
     */
    private function hasBeenGuessed()
    {
        return ( $this->word->getValue() === $this->getWord() );
    }
}

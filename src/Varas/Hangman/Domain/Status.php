<?php

namespace Varas\Hangman\Domain;

/**
 * Game status value object
 */
class Status
{
    const BUSY = 'busy';
    const FAIL = 'fail';
    const SUCCESS = 'success';

    private $triesLeft;
    private $hasBeenGuessed;

    /**
     * @param int   $triesLeft      Tries left
     * @param bool  $hasBeenGuessed True if word has been guessed already
     */
    public function __construct($triesLeft, $hasBeenGuessed)
    {
        if (!is_int($triesLeft) or !is_bool($hasBeenGuessed)) {
            throw new \InvalidArgumentException();
        }
        $this->triesLeft = $triesLeft;
        $this->hasBeenGuessed = $hasBeenGuessed;
    }

    /**
     * @return string   Status value
     */
    public function __toString()
    {
        if ($this->hasBeenGuessed) {
            return self::SUCCESS;
        }

        return $this->triesLeft <= 0 ? self::FAIL : self::BUSY;
    }
}

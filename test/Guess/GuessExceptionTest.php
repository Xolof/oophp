<?php

namespace Anax;

use PHPUnit\Framework\TestCase;
use \Olj\Guess\GuessException;
use \Olj\Guess\Guess;

/**
 * Test cases for class Guess.
 */
class GuessExceptionTest extends TestCase
{
    /**
     * Verify that a guess out of bounds will result
     * in throwing an exception.
     */
    public function testMakeGuessNegative()
    {
        $this->expectException(GuessException::class);

        $guess = new Guess();
        $guess->makeGuess(-1);
    }
}

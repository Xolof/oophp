<?php

namespace Anax;

use PHPUnit\Framework\TestCase;
use \Olj\Guess\Guess;

/**
 * Test cases for class Guess.
 */
class GuessMakeGuessTest extends TestCase
{
    /**
     * Construct object and verify that the function
     * `makeGuess` can handle a guess that is too low.
     */
    public function testMakeGuessTooLow()
    {
        $guess = new Guess(50);
        $res = $guess->makeGuess(49);
        $exp = "Too low";
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the function
     * `makeGuess` can handle a guess that is too high.
     */
    public function testMakeGuessTooHigh()
    {
        $guess = new Guess(50);
        $res = $guess->makeGuess(51);
        $exp = "Too high";
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the function
     * `makeGuess` can handle a guess that is correct.
     */
    public function testMakeGuessCorrect()
    {
        $guess = new Guess(50);
        $res = $guess->makeGuess(50);
        $exp = "Correct";
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that guesses can
     * be exhausted.
     */
    public function testExhaustGuesses()
    {
        $guess = new Guess(42);

        $tries = $guess->tries();

        for ($i = 0; $i < $tries-1; $i++) {
            $guess->makeGuess(1);
        }

        $exp = "No guesses left.";
        $res = $guess->makeGuess(1);

        $this->assertEquals($exp, $res);
    }
}

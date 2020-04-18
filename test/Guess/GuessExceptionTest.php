<?php

namespace Anax;

use PHPUnit\Framework\TestCase;

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
        $this->expectException(\Olj\Guess\GuessException::class);

        $guess = new \Olj\Guess\Guess();
        $guess->makeGuess(-1);
    }
}

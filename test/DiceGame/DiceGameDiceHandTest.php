<?php

namespace Anax;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceGameDiceHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateDiceHand()
    {
        $hand = new \Olj\DiceGame\DiceHand(4);
        $this->assertInstanceOf("\Olj\DiceGame\DiceHand", $hand);
    }

    /**
     * Verify that the average result can be calculated.
     */
    public function testCalcAverage()
    {
        $hand = new \Olj\DiceGame\DiceHand(4);
        $hand->throwDice();
        $expResults = $hand->getResults();
        $exp = round(array_sum($expResults) / count($expResults), 1);
        $res = $hand->calcAverage();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that the sum can be calculated.
     */
    public function testCalcSum()
    {
        $hand = new \Olj\DiceGame\DiceHand(4);
        $hand->throwDice();
        $expResults = $hand->getResults();
        $exp = array_sum($expResults);
        $res = $hand->calcSum();

        $this->assertEquals($exp, $res);
    }
}

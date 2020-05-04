<?php

namespace Anax;

use PHPUnit\Framework\TestCase;
use \Olj\DiceGame\Player;

/**
 * Test cases for class Guess.
 */
class DiceGamePlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreatePlayer()
    {
        $player = new Player("Kjell");
        $this->assertInstanceOf("\Olj\DiceGame\Player", $player);
    }

    /**
     * Check that the Player can make a roll and that something
     * was assigned to the property currentResult.
     */
    public function testMakeRoll()
    {
        $player = new Player("Ros-Marie");
        $player->makeRoll();
        $res = $player->getCurrentResult();

        $this->assertTrue(count($res) > 0);
    }

    /**
     * Check that the total results can be set and returned.
     */
    public function testGetSetTotal()
    {
        $player = new Player("Ros-Marie");
        $player->setTotal(42);
        $res = $player->getTotal();
        $exp = 42;

        $this->assertEquals($res, $exp);
    }

    /**
     * Check that the accumulated result can be set and
     * returned as an integer.
     */
    public function testSetGetAccInt()
    {
        $player = new Player("Ros-Marie");
        $player->setAccArr([[2, 3], [4, 5], [3, 2]]);
        $res = $player->getAccInt();
        $exp = 19;

        $this->assertEquals($res, $exp);
    }

    /**
     * Check that the accumulated result can be set and
     * returned as an array.
     */
    public function testSetGetAccArr()
    {
        $player = new Player("Bertil");
        $player->setAccArr([[2, 6], [4, 5], [3, 4]]);
        $res = $player->getAccArr();
        $exp = [[2, 6], [4, 5], [3, 4]];

        $this->assertEquals($res, $exp);
    }

    /**
     * Check that the current result can be retrieved as an integer.
     */
    public function testGetCurrentResultInt()
    {
        $player = new Player("Gösta");
        $player->makeRoll();

        $res = $player->getCurrentResultInt();

        $this->assertTrue(is_int($res));
    }
}

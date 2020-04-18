<?php

namespace Anax;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceGameGameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateObject()
    {
        $game = new \Olj\DiceGame\Game();
        $this->assertInstanceOf("\Olj\DiceGame\Game", $game);
    }


    /**
     * Assign a current Player to the game and verify it.
     *
     */
    public function testAssignPlayer()
    {
        $game = new \Olj\DiceGame\Game();
        $player = new \Olj\DiceGame\Player("Gordon");

        $game->setCurrentPlayer($player);

        $exp = $player;
        $res = $game->getCurrentPlayer();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test that the function checkIfOne finds a value of one in the current players result.
     */
    public function testCheckIfOne()
    {
        $game = new \Olj\DiceGame\Game();
        $player = new \Olj\DiceGame\Player("Barney");

        $player->currentResult = [4, 1];

        $game->setCurrentPlayer($player);

        $res = $game->checkIfOne();

        $exp = true;

        $this->assertEquals($exp, $res);
    }

    /**
     * Test that the function checkIfOne does'nt return true if there are
     * no values of one in the current players result.
     */
    public function testCheckIfNotOne()
    {
        $game = new \Olj\DiceGame\Game();
        $player = new \Olj\DiceGame\Player("Gina");

        $player->currentResult = [5, 3];

        $game->setCurrentPlayer($player);

        $res = $game->checkIfOne();

        $exp = false;

        $this->assertEquals($exp, $res);
    }

    /**
     * Test that the function getCurrentPlayerName returns
     * the correct name.
     */
    public function testGetCurrentPlayerName()
    {
        $game = new \Olj\DiceGame\Game();
        $player = new \Olj\DiceGame\Player("G-man");
        $game->setCurrentPlayer($player);

        $res = $game->getCurrentPlayerName();
        $exp = "G-man";
        $this->assertEquals($exp, $res);
    }

    /**
     * Test that the function decideBeginner sets a Player
     * for the Game.
     */
    public function testDecideBeginner()
    {
        for ($i = 0; $i < 10; $i++) {
            $game = new \Olj\DiceGame\Game();
            $game->decideBeginner();
    
            $res = $game->getCurrentPlayerName();
    
            $allowedNames = ["computer", "human"];
    
            $this->assertTrue(in_array($res, $allowedNames));
        }
    }
}

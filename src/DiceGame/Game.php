<?php
namespace Olj\DiceGame;

class Game
{
    /**
     * Check if there's a die with value: 1 in the current result.
     *
     * @return void
     */
    public function checkIfOne()
    {
        if (in_array(1, $this->currentPlayer->getCurrentResult())) {
            return true;
        }
    }

    /**
     * Decide who begins.
     *
     * @return void
     */
    public function decideBeginner()
    {
        $singleDie = new SingleDie(6);

        $humanThrow = 0;
        $computerThrow = 0;

        while ($humanThrow == $computerThrow) {
            $humanThrow = $singleDie->roll();

            $computerThrow = $singleDie->roll();

            $result = [$humanThrow, $computerThrow];

            if ($humanThrow > $computerThrow) {
                $this->setCurrentPlayer(new Player("human"));
                break;
            }

            if ($humanThrow < $computerThrow) {
                $this->setCurrentPlayer(new Player("computer"));
                break;
            }
        }
        return $result;
    }

    /**
     * Get the name of the current player.
     *
     * @return string $currentPlayer Name of the current player.
     */
    public function getCurrentPlayerName()
    {
        return $this->currentPlayer->getName();
    }

    /**
     * Set the current player.
     *
     * @return void
     */
    public function setCurrentPlayer(Player $player)
    {
        $this->currentPlayer = $player;
    }

    /**
     * Get the current player object.
     *
     * @return Player $currentPlayer The current player object.
     */
    public function getCurrentPlayer()
    {
        return $this->currentPlayer;
    }
}

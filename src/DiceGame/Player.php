<?php
namespace Olj\DiceGame;

class Player
{
    /**
     * Constructor
     *
     * @param string $name The name of the player.
     *
     * @param int $total The total result of the player.
     *
     */
    public function __construct(string $name, int $total = 0)
    {
        $this->name = $name;
        $this->currentResult = [];
        $this->totalResult = $total;
    }

    /**
     * Throw a hand of dice.
     *
     * @return void
     */
    public function makeRoll()
    {
        $hand = new DiceHand(2);
        $hand->throwDice();
        $this->currentResult = $hand->getResults();
    }

    /**
     * Get current results
     *
     * @return array $res An array containing latest results.
     */
    public function getCurrentResult()
    {
        $res = $this->currentResult;
        return $res;
    }

    /**
     * Get current results as integer
     *
     * @return integer $res Integer value of current result.
     */
    public function getCurrentResultInt()
    {
        $res = intval(array_sum($this->currentResult));
        return $res;
    }

    /**
     * Get total results
     *
     * @return int $res Sum of the total results.
     */
    public function getTotal()
    {
        $res = $this->totalResult;
        return $res;
    }


    /**
     * Set total results
     *
     * @param int $total Sum of the total results.
     *
     * @return void
     */
    public function setTotal($total)
    {
        if ($total != null) {
            $this->totalResult = $total;
        }
    }

    /**
     * Get accumulated results as Integer
     *
     * @return int $res Accumulated results as integer.
     */
    public function getAccInt()
    {
        $res = 0;

        foreach ($this->acc as $item) {
            $res += array_sum($item);
        }
        
        return $res;
    }

    /**
     * Get accumulated results as array
     *
     * @return array $res Accumulated results as array.
     */
    public function getAccArr()
    {
        $res = $this->acc;
        return $res;
    }


    /**
     * Set accumulated results as an array.
     *
     * @param array $accArr An array with the accumulated results.
     *
     * @return void
     */
    public function setAccArr($accArr)
    {
        if ($accArr != []) {
            $this->acc = $accArr;
        }
    }

    /**
     * Get name of the player.
     *
     * @return string $playerName The name of the player.
     */
    public function getName()
    {
        $res = $this->name;
        return $res;
    }
}

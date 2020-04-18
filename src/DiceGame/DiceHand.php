<?php
namespace Olj\DiceGame;

class DiceHand
{
    /**
     * @var SingleDie $dice   Array consisting of dice.
     * @var int  $results  Array consisting of last roll of the dice.
     */
    private $dice;
    private $results;

   /**
     * Constructor to initiate the dicehand with a number of dice.
     *
     * @param int $dice Number of dice to create, defaults to five.
     */
    public function __construct(int $dice = 5)
    {
        $this->dice  = [];
        $this->results = [];

        for ($i = 0; $i < $dice; $i++) {
            $this->dice[]  = new SingleDie(6);
        }
    }

    /**
     * Throw all Dies.
     *
     * @return void.
     */
    public function throwDice()
    {
        foreach ($this->dice as $d) {
            $this->results[] = $d->roll();
        }
    }

    /**
     * Get the results.
     *
     * @return array $results
     */
    public function getResults()
    {
        $results = $this->results;

        return $results;
    }

    /**
     * Calculate the average of the results.
     *
     * @return int $avg The average of the results rounded to 1 decimal.
     */
    public function calcAverage()
    {
        return round(array_sum($this->results) / count($this->results), 1);
    }

    /**
     * Calculate the sum of the results.
     *
     * @return int $sum The sum of the results.
     */
    public function calcSum()
    {
        return array_sum($this->results);
    }
}

<?php
namespace Olj\DiceGame;

class SingleDie
{
    /**
     * Constructor to create a Die.
     *
     * @param int $sides Number of sides of the die.
     *
     */
    public function __construct(int $sides)
    {
        $this->sides = $sides;
    }

    /**
     * Throw a Die a number of times.
     *
     * @param int $times Number of times to throw the die.
     *
     * @return array $result Results of the throws.
     */
    public function roll()
    {
        return round(rand(1, $this->sides));
    }
}

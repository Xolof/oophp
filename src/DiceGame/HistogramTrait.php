<?php

namespace Olj\DiceGame;

/**
 * A trait implementing a histogram for integers.
 */
trait HistogramTrait
{
      /**
     * @var array $series The numbers stored in the sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $series = [];
    private $min;
    private $max;

    /**
     * Inject the array to use as base for the histogram data.
     *
     */
    public function injectData(array $arr, $min = 1, $max = 6)
    {
        $this->series = $arr;
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Get the series.
     *
     * @return array with the series.
     */
    public function getSeries()
    {
        return $this->series;
    }


    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        $result = "";

        $series = $this->series;
        $countValues = [];

        if ($this->min === null && $this->max === null) {
            $result = $this->getAsTextNoMinMax($series, $countValues);
        } else if ($this->min != null && $this->max != null) {
            $result = $this->getAsTextMinMax($series, $countValues);
        }

        return $result;
    }


    /**
     * Get the throws represented as a string.
     *
     * @param int $val The number of throws for a side of the die.
     *
     * @return string representing the throws.
     */
    public function getDiceString($val)
    {
        $diceStr = "";
        for ($i = 0; $i < $val; $i++) {
            $diceStr .= "*";
        }
        return $diceStr;
    }

    /**
     * Print a string with a textual representation of the histogram if min and max are specified.
     */
    public function getAsTextMinMax($series, $countValues)
    {
        $result = "";
    
        foreach ($series as $i) {
            array_key_exists(intval($i), $countValues) ? $countValues[intval($i)] += 1 :  $countValues[intval($i)] = 1;
        }

        for ($i = $this->min; $i <= $this->max; $i++) {
            if (!in_array($i, $series)) {
                $countValues[intval($i)] = 0;
            }
        };

        ksort($countValues);

        foreach ($countValues as $key => $val) {
            if ($key >= $this->min && $key <= $this->max) {
                $diceStr = $this->getDiceString($val);
                $result .= "<p>" . $key . ": " . $diceStr . "</p>";
            }
        };

        $result .= "<br>";

        return $result;
    }

    /**
     * Print a string with a textual representation of the histogram if min and max are not specified.
     */
    public function getAsTextNoMinMax($series, $countValues)
    {
        $result = "";

        foreach ($series as $val) {
            array_key_exists(intval($val), $countValues) ? $countValues[intval($val)] += 1 :  $countValues[intval($val)] = 1;
        }

        ksort($countValues);

        foreach ($countValues as $key => $val) {
            $diceStr = $this->getDiceString($val);
            $result .= "<p>" . $key . ": " . $diceStr . "</p>";
        };

        $result .= "<br>";

        return $result;
    }
}

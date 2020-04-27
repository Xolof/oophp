<?php

namespace Olj\DiceGame;

/**
 * A interface for a classes supporting histogram reports.
 */
interface HistogramInterface
{
    /**
     * Inject the array to use as base for the histogram data.
     *
     */
    public function injectData(array $arr);

    /**
     * Get the series.
     *
     * @return array with the series.
     */
    public function getSeries();


    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText();


    /**
     * Get the throws represented as a string.
     *
     * @param int $val The number of throws for a side of the die.
     *
     * @return string representing the throws.
     */
    public function getDiceString($val);


    /**
     * Print a string with a textual representation of the histogram if min and max are specified.
     */
    public function getAsTextMinMax($series, $countValues);


    /**
     * Print a string with a textual representation of the histogram if min and max are not specified.
     */
    public function getAsTextNoMinMax($series, $countValues);
}

<?php

namespace Anax;

use PHPUnit\Framework\TestCase;
use \Olj\DiceGame\Histogram;

/**
 * Test cases for class Guess.
 */
class DiceGameHistogramTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateHistogram()
    {
        $histogram = new Histogram();
        $this->assertInstanceOf("\Olj\DiceGame\Histogram", $histogram);
    }

    /**
     * Verify that the series can be retrieved.
     */
    public function testGetSeries()
    {
        $histogram = new Histogram();
        $histogram->injectData([1, 3, 2, 5]);
        $res = $histogram->getSeries();
        $exp = [1, 3, 2, 5];
        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that the series can be retrieved as with min and max value set.
     */
    public function testGetAsTextMinMax()
    {
        $histogram = new Histogram();
        $histogram->injectData([1, 2, 2, 3, 3, 3], 1, 4);
        $res = $histogram->getAsText();
        $exp = "<p>1: *</p><p>2: **</p><p>3: ***</p><p>4: </p><br>";
        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that the series can be retrieved as without min and max value set.
     */
    public function testGetAsTextNoMinMax()
    {
        $histogram = new Histogram();
        $histogram->injectData([1, 2, 2, 3, 3, 3], null, null);
        $res = $histogram->getAsText();
        $exp = "<p>1: *</p><p>2: **</p><p>3: ***</p><br>";
        $this->assertEquals($exp, $res);
    }
}

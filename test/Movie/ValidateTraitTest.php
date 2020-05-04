<?php

namespace Anax;

use PHPUnit\Framework\TestCase;
use \Olj\Movie\MovieAdd;
use \Olj\Movie\ValidateObject;

/**
 * Testing an object implementing the Validate trait.
 */
class ValidateTraitTest extends TestCase
{
    /**
     * Test validating filenames for images.
     */
    public function testValidateTrait()
    {
        $valObj1 = new ValidateObject("invalid");
        $res = $valObj1->validate();
        $exp = false;
        $this->assertEquals($res, $exp);

        $valObj2 = new ValidateObject("img/mypic.jpg");
        $res = $valObj2->validate();
        $exp = true;
        $this->assertEquals($res, $exp);

        $valObj3 = new ValidateObject("dir/..dir/dir../../script.php");
        $res = $valObj3->validate();
        $exp = false;
        $this->assertEquals($res, $exp);
    }
}

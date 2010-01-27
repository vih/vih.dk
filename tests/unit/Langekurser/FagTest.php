<?php
require_once dirname(__FILE__) . '/../config.test.php';

class FagTest extends PHPUnit_Framework_TestCase
{
    function testConstruction()
    {
        $fag = new VIH_Model_Fag();
        $this->assertTrue(is_object($fag));
    }
}


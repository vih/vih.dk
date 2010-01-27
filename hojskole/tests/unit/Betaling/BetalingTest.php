<?php
require_once dirname(__FILE__) . '/../config.test.php';

class BetalingTest extends PHPUnit_Framework_TestCase
{
    private $betaling;

    function setUp()
    {
        $this->betaling = new VIH_Model_Betaling('kortekurser', 1);
    }

    function testBetalingWillAtLeastSaveWith4CifreId()
    {
        $data = array('type' => 'kontant', 'amount' => 1000);
        $this->assertTrue($this->betaling->save($data) > 0);
        $this->assertTrue($this->betaling->get('id') >= 1000);

    }
}

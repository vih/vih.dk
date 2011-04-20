<?php
require_once dirname(__FILE__) . '/../config.test.php';

class BetalingTest extends PHPUnit_Framework_TestCase
{
    protected $backupGlobals = false;
    private $betaling;

    function setUp()
    {
        $this->betaling = new VIH_Model_Betaling('kortekurser', 1);
    }

    function tearDown()
    {
        $db = MDB2::factory(DB_DSN);
        $db->exec('TRUNCATE betaling');
    }

    function testBetalingWillAtLeastSaveWithFourCifreId()
    {
        $data = array('type' => 'kontant', 'amount' => 1000);
        $this->assertTrue($this->betaling->save($data) > 0, 'save returns false');
        $this->assertTrue($this->betaling->get('id') >= 1000, 'id is not greater than 1000');
    }
}

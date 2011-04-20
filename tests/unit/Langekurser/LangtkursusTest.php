<?php
require_once dirname(__FILE__) . '/../config.test.php';

class FakeLangtKursusPeriode
{
    function getId()
    {
        return 1;
    }
}

class FakeLangtKursusFag
{
    function getId()
    {
        return 1;
    }
}

class LangtKursusTest extends PHPUnit_Framework_TestCase
{
    protected $backupGlobals = false;

    function testConstruction()
    {
        $kursus = new VIH_Model_LangtKursus();
        $this->assertTrue(is_object($kursus));
    }

    function tearDown()
    {
        $db = MDB2::factory(DB_DSN);
        $db->exec('TRUNCATE langtkursus');
    }

    function testSaveReturnsTrueOnValidData()
    {
        $data = array('navn' => 'tests');
        $kursus = new VIH_Model_LangtKursus();
        $this->assertTrue($kursus->save($data) > 0);
        $this->assertEquals('tests', $kursus->get('navn'));
    }

    function testSaveWithAnEmptyArrayTriggersNoNotices()
    {
        $data = array();
        $kursus = new VIH_Model_LangtKursus();
        $this->assertTrue($kursus->save($data) > 0);
    }
}
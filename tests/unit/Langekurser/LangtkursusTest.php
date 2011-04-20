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

    /*
    function testAddFag()
    {
        $data = array('navn' => 'tests');
        $kursus = new VIH_Model_LangtKursus();
        $this->assertTrue($kursus->save($data) > 0);
        $fagperiode = new VIH_Model_LangtKursus_FagPeriode(new FakeLangtKursusFag, new FakeLangtKursusPeriode);
        $this->assertTrue($kursus->addFag($fagperiode));
    }
    */
}
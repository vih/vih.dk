<?php
require_once dirname(__FILE__) . '/../config.test.php';

class FakeKortKursus
{
    private $values;

    function __construct()
    {
        $this->values['navn'] = 'Kursus (kopi)';
        $this->values['uge'] = 23;
        $this->values['dato_start'] = '2007-10-10';
        $this->values['dato_slut'] = '2007-10-17';
        $this->values['nyhed'] = 0;
        $this->values['description'] = 'Beskrivelse';
        $this->values['beskrivelse'] = 'Beskrivelse';
        $this->values['minimumsalder'] = 18;
        $this->values['ansat_id'] = 0;
        $this->values['begyndere'] = 0;
        $this->values['title'] = 'Title';
        $this->values['keywords'] = 'keywords';
        $this->values['tekst'] = 'Tekst';
        $this->values['type'] = 'golf';
        $this->values['gruppe_id'] = 1;
        $this->values['underviser_id'] = 1;
        $this->values['pris'] = 200;
        $this->values['pris_boern'] = 0;
        $this->values['pris_depositum'] = 100;
        $this->values['pris_afbestillingsforsikring'] = 100;
        $this->values['indkvartering_key'] = 1;
        $this->values['pladser'] = 20;
        $this->values['vaerelser'] = 20;
        $this->values['pic_id'] = 0;
        $this->values['status'] = 0;
        $this->values['tilmeldingsmulighed'] = 1;
        $this->values['published'] = 0; // aldrig udgive dem før de er blevet kigget igennem
    }

    function get($key)
    {
        return $this->values[$key];
    }
}

class KortKursusTest extends PHPUnit_Framework_TestCase
{
    private $db;
    protected $backupGlobals = false;

    function setUp()
    {
        $this->db = MDB2::singleton(DB_DSN);
    }

    function tearDown()
    {
        $this->db->query('TRUNCATE kortkursus_tilmelding');
        $this->db->query('TRUNCATE kortkursus_deltager_ny');
    }

    function createKortKursus()
    {
        $data = array('navn' => 'test',
                      'dato_start' => date('Y-m-d'),
                      'dato_slut' => date('Y-m-d'),
                      'gruppe_id' => 1);
        $kursus = new VIH_Model_KortKursus();
        $kursus->save($data);
        return $kursus;
    }

    function testConstruction()
    {
        $kursus = new VIH_Model_KortKursus();
        $this->assertTrue(is_object($kursus));
    }

    function testSaveReturnsTrueOnValidData()
    {
        $data = array('navn' => 'test',
                      'dato_start' => date('Y-m-d'),
                      'dato_slut' => date('Y-m-d'));
        $kursus = new VIH_Model_KortKursus();
        $this->assertTrue($kursus->save($data) > 0);
        $this->assertEquals('test', $kursus->get('navn'));
    }


    function testCopy()
    {
        $kursus = new FakeKortKursus;

        $new_kursus = new VIH_Model_KortKursus();
        $this->assertTrue($new_kursus->copy($kursus) > 0);
    }

    function testGetBegyndereReturnsZeroWhenNobodyHasBeenAdded()
    {
        $kursus = new FakeKortKursus;
        $new_kursus = new VIH_Model_KortKursus();
        $this->assertTrue($new_kursus->copy($kursus) > 0);

        $this->assertEquals(0, $new_kursus->getBegyndere());
    }

    function testGetDeltagereReturnsAnEmptyArrayWhenNobodyHasBeenAddedYet()
    {
        $kursus = new FakeKortKursus;
        $new_kursus = new VIH_Model_KortKursus();
        $this->assertTrue($new_kursus->copy($kursus) > 0);

        $this->assertTrue(is_array($new_kursus->getDeltagere()));
        $this->assertEquals(0, count($new_kursus->getDeltagere()));
    }

    function testGetDeltagereReturnsTheCorrectNumberOfDeltagereWhenOneIsAdded()
    {
        $kursus = $this->createKortKursus();
        $session_id = rand(1, 1000000000);
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($session_id);
        $data = array('kursus_id' => $kursus->getId(), 'antal_deltagere' => 1);

        $tilmelding->start($data);

        $data = array(
            'kursus_id' => $this->createKortKursus()->getId(),
            'kontaktnavn' => 'Test',
            'adresse' => 'Test',
            'postnr' => 'Test',
            'postby' => 'Test',
            'email' => 'Test',
            'mobil' => 'Test',
            'telefonnummer' => 'Test',
            'mobil' => 'Test',
            'besked' => '',
            'afbestillingsforsikring' => '');

        $tilmelding->save($data);

        $deltager = new VIH_Model_KortKursus_Tilmelding_Deltager($tilmelding);

        $data = array('navn' => 'tester', 'cpr' => '140676-9999', 'handicap' => 70, 'klub' => 'none', 'dgu' => 'nej');

        $deltager->save($data);

        $tilmelding->confirm();

        $this->assertTrue(is_array($kursus->getDeltagere()));
        $this->assertEquals(1, count($kursus->getDeltagere()));
    }

    function testGetBegyndereReturnsTheCorrectNumberOfDeltagereWhenOneIsAdded()
    {
        $kursus = $this->createKortKursus();
        $session_id = rand(1, 1000000000);
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($session_id);
        $data = array('kursus_id' => $kursus->getId(), 'antal_deltagere' => 1);

        $tilmelding->start($data);

        $data = array(
            'kursus_id' => $this->createKortKursus()->getId(),
            'kontaktnavn' => 'Test',
            'adresse' => 'Test',
            'postnr' => 'Test',
            'postby' => 'Test',
            'email' => 'Test',
            'mobil' => 'Test',
            'telefonnummer' => 'Test',
            'mobil' => 'Test',
            'besked' => '',
            'afbestillingsforsikring' => '');

        $tilmelding->save($data);

        // add a beginner
        $deltager = new VIH_Model_KortKursus_Tilmelding_Deltager($tilmelding);
        $data = array('navn' => 'tester', 'cpr' => '140676-9999', 'handicap' => 70, 'klub' => 'none', 'dgu' => 'nej');
        $deltager->save($data);

        // add a nonbeginner
        $deltager = new VIH_Model_KortKursus_Tilmelding_Deltager($tilmelding);
        $data = array('navn' => 'tester', 'cpr' => '140676-9999', 'handicap' => 10, 'klub' => 'none', 'dgu' => 'nej');
        $deltager->save($data);

        $tilmelding->confirm();

        $this->assertEquals(1, $kursus->getBegyndere());
    }
}
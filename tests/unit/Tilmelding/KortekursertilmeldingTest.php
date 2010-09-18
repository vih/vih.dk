<?php
require_once dirname(__FILE__) . '/../config.test.php';

class FakeKorteKurserTilmelding extends VIH_Model_KortKursus_Tilmelding
{
    public $value;
    public $id;

    function __construct()
    {
        $this->id = 1;
        $this->value = array(
            'id' => 1,
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
    }
}

class FakeKorteKurserTilmeldingEverythingPaid extends VIH_Model_KortKursus_Tilmelding
{
    function loadBetaling()
    {
        $this->value['betalt'] = 1000;
        $this->value['betalt_not_approved'] = 0;
        $this->value['saldo'] = 0;
        $this->value['skyldig_depositum'] = 0;
        $this->value['skyldig'] = 0;

        $this->value['forfalden'] = 0;
        $this->value['forfalden_depositum'] = 0;
        $this->value['forfalden'] = 0;
        $this->_updateStatus();
    }
}

class FakeKortekurserTilmeldingDepositPaid extends VIH_Model_KortKursus_Tilmelding
{
    function loadBetaling()
    {
        $this->value['betalt'] = 1000;
        $this->value['betalt_not_approved'] = 0;
        $this->value['saldo'] = 1000;
        $this->value['skyldig_depositum'] = 0;
        $this->value['skyldig'] = 1000;

        $this->value['forfalden'] = 0;
        $this->value['forfalden_depositum'] = 0;
        $this->value['forfalden'] = 0;
        $this->_updateStatus();
    }
}

class KortekursertilmeldingTest extends PHPUnit_Framework_TestCase
{
    protected $backupGlobals = false;

    function createKortKursusId()
    {
        $data = array('navn' => 'test',
                      'dato_start' => date('Y-m-d'),
                      'dato_slut' => date('Y-m-d'));
        $kursus = new VIH_Model_KortKursus();
        return $kursus->save($data);
    }

    function createGolfKursus()
    {

        $data = array('navn' => 'test',
                      'dato_start' => date('Y-m-d'),
                      'dato_slut' => date('Y-m-d'),
                      'gruppe_id' => 1);
        $kursus = new VIH_Model_KortKursus();
        $kursus->save($data);
        return $kursus;
    }

    function testSessionIdStaysTheSameOnTwoOnlineTilmelding()
    {
        $data = array('kursus_id' => $this->createKortKursusId(), 'antal_deltagere' => 1);
        $session_id = rand(1, 1000000000);
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($session_id);
        $this->assertTrue($tilmelding->start($data) > 0);

        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($session_id);
        $this->assertEquals($tilmelding->get('session_id'), $session_id);
    }

    function testThatStatusSettingIsWorking()
    {
        $data = array('kursus_id' => $this->createKortKursusId(), 'antal_deltagere' => 1);
        $session_id = rand(1, 1000000000);
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($session_id);
        $this->assertTrue($tilmelding->start($data) > 0);
        $this->assertEquals('undervejs', $tilmelding->getStatus());
        $tilmelding->setStatus('reserveret');
        $this->assertEquals('reserveret', $tilmelding->getStatus());
        $tilmelding->setStatus('tilmeldt');
        $this->assertEquals('tilmeldt', $tilmelding->getStatus());
    }

    function testUpdateStatusSetsStatusToDeletedWhenTilmeldingNotActive()
    {
        $data = array('kursus_id' => $this->createKortKursusId(), 'antal_deltagere' => 1);
        $session_id = rand(1, 1000000000);
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($session_id);
        $id = $tilmelding->start($data);
        $tilmelding = new VIH_Model_KortKursus_Tilmelding($id);
        $this->assertTrue($tilmelding->delete());
        $this->assertEquals('slettet', $tilmelding->getStatus());
    }

    function testUpdateStatusSetsStatusToAfsluttetWhenDepositIsPaid()
    {
        $data = array('kursus_id' => $this->createKortKursusId(), 'antal_deltagere' => 1);
        $session_id = rand(1, 1000000000);
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($session_id);
        $id = $tilmelding->start($data);
        $tilmelding = new FakeKorteKurserTilmeldingDepositPaid($id);
        $tilmelding->loadBetaling();
        $this->assertEquals('tilmeldt', $tilmelding->getStatus());
    }

    function testUpdateStatusSetsStatusToAfsluttetWhenDIsPaid()
    {
        $data = array('kursus_id' => $this->createKortKursusId(), 'antal_deltagere' => 1);
        $session_id = rand(1, 1000000000);
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($session_id);
        $id = $tilmelding->start($data);
        $tilmelding = new FakeKorteKurserTilmeldingEverythingPaid($id);
        $tilmelding->loadBetaling();
        $this->assertEquals('afsluttet', $tilmelding->getStatus());
    }

    function testSaveCanOnlyUpdateOnAnOnlineTilmeldingTryOtherwiseAndAnExceptionIsThrown()
    {
        $data = array(
            'kursus_id' => $this->createKortKursusId(),
            'kontaktnavn' => 'Test',
            'adresse' => 'Test',
            'postnr' => 'Test',
            'postby' => 'Test',
            'email' => 'Test',
            'mobil' => 'Test',
            'telefonnummer' => 'Test',
            'mobil' => 'Test');

        $tilmelding = new VIH_Model_KortKursus_Tilmelding();
        try {
            $tilmelding->save($data);
            $this->assertTrue(false, 'Uncaught exception');
        } catch (Exception $e) {
            $this->assertTrue(true);
        }
    }

    function testSaveCanUpdateAndAddInfoToAnOnlineTilmelding()
    {
        $kort_kursus_id = $this->createKortKursusId();
        $data = array('kursus_id' => $kort_kursus_id, 'antal_deltagere' => 1);
        $session_id = rand(1, 1000000000);
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($session_id);
        $this->assertTrue($id = $tilmelding->start($data) > 0);

        $data = array(
            'kursus_id' => $kort_kursus_id,
            'kontaktnavn' => 'Test',
            'adresse' => 'Test',
            'postnr' => '2000',
            'postby' => 'Test',
            'email' => 'Test',
            'mobil' => 'Test',
            'telefonnummer' => 'Test',
            'mobil' => 'Test',
            'besked' => 'test',
            'afbestillingsforsikring' => 'Ja');

        $tilmelding = new VIH_Model_KortKursus_Tilmelding($id);
        $this->assertTrue($tilmelding->save($data) > 0);
    }

    function testDeltagerOplysning()
    {
        $kursus = $this->createGolfKursus();
        $session_id = rand(1, 1000000000);
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($session_id);
        $data = array('kursus_id' => $kursus->getId(), 'antal_deltagere' => 1);

        $tilmelding->start($data);

        $data = array(
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

        $this->assertEquals(70, $deltager->getOplysninger()->get('handicap'));
        $this->assertEquals('none', $deltager->getOplysninger()->get('klub'));
        $this->assertEquals('nej', $deltager->getOplysninger()->get('dgu'));
    }

    function testDeltagerOplysningCanSaveEmptyValue()
    {
        $kort_kursus_id = $this->createKortKursusId();
        $data = array('kursus_id' => $kort_kursus_id, 'antal_deltagere' => 1);
        $session_id = uniqid();
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($session_id);

        $tilmelding->start($data);

        // add a beginner
        $deltager = new VIH_Model_KortKursus_Tilmelding_Deltager($tilmelding);
        $data = array('navn' => 'tester', 'cpr' => '140676-9999', 'handicap' => 70, 'klub' => 'none', 'dgu' => 'nej');
        $deltager->save($data);

        $data = array('navn' => 'tester', 'cpr' => '140676-9999', 'handicap' => 70, 'klub' => '', 'dgu' => 'nej');
        $deltager->save($data);

    }
}
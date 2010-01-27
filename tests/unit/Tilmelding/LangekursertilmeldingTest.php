<?php
require_once dirname(__FILE__) . '/../config.test.php';

class FakeTilmeldingFag
{
    private $id;

    function __construct($id = 1)
    {
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }
}

class LangekurserTilmeldingTest extends PHPUnit_Framework_TestCase
{
    protected $backupGlobals = false;
    /*
    function tearDown()
    {
        $db = MDB2::factory(DB_DSN);
        $db->query('TRUNCATE langtkursus_tilmelding_ny');
        $db->query('TRUNCATE langtkursus_rate');
        $db->query('TRUNCATE langtkursus_tilmelding_rate');
        $db->query('TRUNCATE betaling');
    }
    */

    function testSessionIdStaysTheSameOnTwoOnlineTilmelding()
    {
        $session_id = rand(1, 1000000000);
        $tilmelding = new VIH_Model_LangtKursus_OnlineTilmelding($session_id);
        $this->assertTrue($tilmelding->start());

        $tilmelding = new VIH_Model_LangtKursus_OnlineTilmelding($session_id);
        $this->assertEquals($tilmelding->get('session_id'), $session_id);
    }

    function testSave()
    {
        $data = array(
            'kursus_id' => 1,
            'navn' => 'Test',
            'adresse' => 'Test',
            'postnr' => 'Test',
            'postby' => 'Test',
            'email' => 'Test',
            'mobil' => 'Test',
            'telefonnummer' => 'Test',
            'mobil' => 'Test',
            'arbejdstelefon' => 'Test',
            'kontakt_navn' => 'Test',
            'kontakt_adresse' => 'Test',
            'kontakt_postnr' => 'Test',
            'kontakt_postby' => 'Test',
            'kontakt_email' => 'Test',
            'kontakt_mobil' => 'Test',
            'kontakt_telefon' => 'Test',
            'kontakt_arbejdstelefon' => 'Test',
            'uddannelse' => 'Test',
            'betaling' => 'Test',
            'besked' => 'test',
            'nationalitet' => 'DK',
            'kommune' => 'Test',
            'ryger' => 'Nej',
            'sex' => 'M',
            'fag_id' => 1,
            'tekst_diplom' => 'test'
        );

        $session_id = rand(1, 1000000000);
        $tilmelding = new VIH_Model_LangtKursus_OnlineTilmelding($session_id);
        $tilmelding->start();
        $this->assertTrue($tilmelding->save($data) > 0);
        $this->assertEquals('undervejs', $tilmelding->get('status'));
    }

    function testUpdateRater()
    {
        $tilmelding = $this->createTilmelding();
        $this->assertTrue($tilmelding->_updateStatus());
        $this->assertEquals('reserveret', $tilmelding->get('status'));
        $tilmelding->createRate(date('Y-m-d'), 1000);
        $tilmelding->createRate(date('Y-m-d'), 2000);
        $tilmelding->createRate(date('Y-m-d'), 2000);
        $priser = array('elevstotte' => 0,
                        'ugeantal_elevstotte' => 0,
                        'statsstotte' => 0,
                        'kommunestotte' => 0,
                        'aktiveret_tillaeg' => 0,
                        'kompetencestotte' => 0,
                        'pris_uge' => 1000,
                        'ugeantal' => 5,
                        'pris_tilmeldingsgebyr' => 1000,
                        'pris_materiale' => 0,
                        'pris_rejsedepositum' => 0,
                        'pris_rejserest' => 0,
                        'pris_rejselinje' => 0,
                        'pris_noegledepositum' => 0,
                        'dato_start' => date('Y-m-d'),
                        'dato_slut' => '2008-10-10',
                        'pris_afbrudt_ophold' => 0
        );
        $this->assertTrue($tilmelding->savePriser($priser));
        $this->assertEquals(6000, $tilmelding->get('pris_total'));
        $this->assertEquals(0, $tilmelding->rateDifference());
        $this->assertTrue($tilmelding->_updateStatus());
        $this->assertTrue($tilmelding->betaling_loaded);
        $this->assertEquals('reserveret', $tilmelding->get('status'));
        $betaling = $tilmelding->betalingFactory();
        $this->assertTrue(is_object($betaling));
        $betaling->save(array('type' => 'kontant', 'amount' => 1000));
        $betaling->setStatus('approved');
        $tilmelding->loadBetaling();
        $this->assertTrue($tilmelding->_updateStatus());
        $this->assertEquals('tilmeldt', $tilmelding->get('status'));
        $betaling = $tilmelding->betalingFactory();
        $betaling->save(array('type' => 'kontant', 'amount' => 5000));
        $betaling->setStatus('approved');
        $tilmelding->loadBetaling();
        $this->assertEquals('afsluttet', $tilmelding->get('status'));

    }

    function testAddFag()
    {
        $tilmelding = new VIH_Model_LangtKursus_Tilmelding(1);
        $periode = new FakeTilmeldingFag;
        $this->assertTrue($tilmelding->addFag(new FakeTilmeldingFag, $periode));
    }

    function testGetFag()
    {

        $this->markTestIncomplete('Has been changed');
        $tilmelding = new VIH_Model_LangtKursus_Tilmelding(1);
        $periode = new FakeTilmeldingFag;
        $tilmelding->addFag(new FakeTilmeldingFag, $periode);
        $db = new pdoext_Connection("mysql:dbname=" . DB_NAME . ";host=" . DB_HOST, DB_USER, DB_PASSWORD);
        $fag = $tilmelding->getFag($db);
        $this->assertTrue(is_array($fag));
        foreach ($fag as $f) {
            $this->assertTrue(is_object($f));
        }
    }

    function testHasSelectedFagReturnsTrueIfUserHasSelectedTheSubjectInThePeriod()
    {
        $tilmelding = new VIH_Model_LangtKursus_Tilmelding(1);
        $periode = new FakeTilmeldingFag;
        $tilmelding->addFag(new FakeTilmeldingFag, $periode);
        $this->assertTrue($tilmelding->hasSelectedFag(new FakeTilmeldingFag, $periode));
    }

    function testHasSelectedFagReturnsFalseIfUserHasSelectedTheSubjectButNotInThatPeriod()
    {
        $tilmelding = new VIH_Model_LangtKursus_Tilmelding(1);
        $periode = new FakeTilmeldingFag(1);
        $tilmelding->addFag(new FakeTilmeldingFag, $periode);
        $another_periode = new FakeTilmeldingFag(2);
        $this->assertFalse($tilmelding->hasSelectedFag(new FakeTilmeldingFag, $another_periode));
    }

    function testHasSelectedFagReturnsFalseIfUserHasNotSelectedTheSubject()
    {
        $tilmelding = new VIH_Model_LangtKursus_Tilmelding(1);
        $periode = new FakeTilmeldingFag;
        $tilmelding->addFag(new FakeTilmeldingFag(1), $periode);
        $this->assertFalse($tilmelding->hasSelectedFag(new FakeTilmeldingFag(2), $periode));
    }


    function testSavePriser()
    {
        $tilmelding = $this->createTilmelding();
        $this->assertTrue($tilmelding->savePriser(array('dato_start' => '2007-10-10',
                                      'dato_slut' => '2007-12-12',
                                      'elevstotte' => 200,
                                      'ugeantal_elevstotte' => 200,
                                      'statsstotte' => 200,
                                      'kommunestotte' => 200,
                                      'aktiveret_tillaeg' => 200,
                                      'kompetencestotte' => 200,
                                      'pris_uge' => 200,
                                      'ugeantal' => 200,
                                      'pris_tilmeldingsgebyr' => 200,
                                      'pris_materiale' => 200,
                                      'pris_rejsedepositum' => 200,
                                      'pris_rejserest' => 200,
                                      'pris_rejselinje' => 300,
                                      'pris_noegledepositum' => 200,
                                      'pris_afbrudt_ophold' => 200)));

    }

    function testGetWeeks()
    {
        $tilmelding = $this->createTilmelding();
        $tilmelding->savePriser(array('dato_start' => '2007-10-10',
                                      'dato_slut' => '2007-12-12',
                                      'elevstotte' => 200,
                                      'ugeantal_elevstotte' => 200,
                                      'statsstotte' => 200,
                                      'kommunestotte' => 200,
                                      'aktiveret_tillaeg' => 200,
                                      'kompetencestotte' => 200,
                                      'pris_uge' => 200,
                                      'ugeantal' => 200,
                                      'pris_tilmeldingsgebyr' => 200,
                                      'pris_materiale' => 200,
                                      'pris_rejsedepositum' => 200,
                                      'pris_rejserest' => 200,
                                      'pris_rejselinje' => 300,
                                      'pris_noegledepositum' => 200,
                                      'pris_afbrudt_ophold' => 200));
        $this->assertEquals(9, $tilmelding->getWeeks());
    }

    /////////////////////////////////////////////////////////////////////

    function createTilmelding()
    {
        $data = array(
            'kursus_id' => 1,
            'navn' => 'Emanuel Wani Lado',
            'adresse' => 'Jens Juelsvej 56, 4. sal',
            'postnr' => '5230',
            'postby' => 'Odense M',
            'email' => 'lars@legestue.net',
            'mobil' => '30587032',
            'telefonnummer' => '30587032',
            'arbejdstelefon' => '30587032',
            'cpr' => '1406909999',
            'kontakt_navn' => 'Præst - Domhuset - Odense Leif og Lis Munksgaard',
            'kontakt_adresse' => 'Folkekirkens Tværkultur, Smarilis, Vestagergade 51B',
            'kontakt_postnr' => '5000',
            'kontakt_postby' => 'Odense C',
            'kontakt_email' => '',
            'kontakt_mobil' => '63120873',
            'kontakt_telefon' => '63120873',
            'kontakt_arbejdstelefon' => '63120873',
            'uddannelse' => 'Ingen',
            'betaling' => '1',
            'besked' => 'Rikke Mandrup, Garanti højskolernes sekretariat',
            'nationalitet' => 'Sudan',
            'kommune' => 'Odense',
            'ryger' => 'Nej',
            'sex' => 'M',
            'fag_id' => 1,
            'tekst_diplom' => 'test'
        );

        $session_id = rand(1, 1000000000);
        $tilmelding = new VIH_Model_LangtKursus_OnlineTilmelding($session_id);
        $tilmelding->start();
        $tilmelding->save($data);

        $data = array('dato_start' => '2007-10-10',
                            'dato_slut' => '2007-12-12',
                                      'elevstotte' => 200,
                                      'ugeantal_elevstotte' => 200,
                                      'statsstotte' => 200,
                                      'kommunestotte' => 200,
                                      'aktiveret_tillaeg' => 200,
                                      'kompetencestotte' => 200,
                                      'pris_uge' => 200,
                                      'ugeantal' => 200,
                                      'pris_tilmeldingsgebyr' => 200,
                                      'pris_materiale' => 200,
                                      'pris_rejsedepositum' => 200,
                                      'pris_rejserest' => 200,
                                      'pris_rejselinje' => 300,
                                      'pris_noegledepositum' => 200,
                                      'pris_afbrudt_ophold' => 200);
        $tilmelding->savePriser($data);
        $tilmelding->setStatus('reserveret');
        return $tilmelding;
    }

    function testGetAge()
    {
        $tilmelding = $this->createTilmelding();
        $this->assertEquals(17.3178082192, $tilmelding->getAge(), '', 0.01);
    }
}

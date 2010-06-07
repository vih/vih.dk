<?php
require_once dirname(__FILE__) . '/../config.test.php';

class FagGruppeTest extends PHPUnit_Framework_TestCase
{
    private $gruppe;
    protected $backupGlobals = false;

    function setUp()
    {
        $this->faggruppe = new VIH_Model_Fag_Gruppe();
    }

    function testConstruction()
    {
        $this->assertTrue(is_object($this->faggruppe));
    }

    function testSave()
    {
        $data = array('show_description' => 1, 'published' => 1, 'description' => 'Test', 'valgfag' => 1, 'navn' => 'navn', 'beskrivelse' => 'beskrivelse', 'vis_diplom' => 1);
        $this->assertTrue($this->faggruppe->save($data) > 0);
    }
}
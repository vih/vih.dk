<?php
require_once dirname(__FILE__) . '/../config.test.php';

class MaterialeBestillingTest extends PHPUnit_Framework_TestCase {

    function testConstruction()
    {
        $bestilling = new VIH_Model_MaterialeBestilling();
        $this->assertTrue(is_object($bestilling));
    }

    function testSave()
    {
        $data = array(
            'navn' => 'Test',
            'adresse' => 'Test',
            'postnr' => '9000',
            'postby' => 'Test',
            'email' => 'lars@legestue.net',
            'telefon' => 'Test',
            'besked' => 'Test',
            'langekurser' => '1',
            'kortekurser' => '1',
            'kursuscenter' => '1',
            'efterskole' => '1'
        );

        $bestilling = new VIH_Model_MaterialeBestilling();
        $this->assertTrue($bestilling->save($data));

    }
}
?>
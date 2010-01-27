<?php
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

class LangeKurser_AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Langekurser');

        $tests = array('Langtkursus', 'Fag', 'Faggruppe');

        foreach ($tests as $test) {
            require_once $test . 'Test.php';
            $suite->addTestSuite($test . 'Test');
        }

        return $suite;
    }
}

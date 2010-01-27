<?php
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

class KorteKurser_AllTests
{

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kortekurser');

        $tests = array('Kortkursus');

        foreach ($tests as $test) {
            require_once $test . 'Test.php';
            $suite->addTestSuite($test . 'Test');
        }

        return $suite;
    }
}
?>
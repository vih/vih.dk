<?php
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

class MaterialeBestilling_AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('materialebestilling');

        $tests = array('Materialebestilling');

        foreach ($tests as $test) {
            require_once $test . 'Test.php';
            $suite->addTestSuite($test . 'Test');
        }

        return $suite;
    }
}
?>
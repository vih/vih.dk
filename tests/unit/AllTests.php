<?php
require_once 'k.php';
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

PHPUnit_Util_Filter::addDirectoryToWhitelist(realpath(dirname(__FILE__) . '/../../src/VIH'), '.php');
PHPUnit_Util_Filter::removeDirectoryFromWhitelist(realpath(dirname(__FILE__) . '/../../src/VIH/View/'), '.php');
PHPUnit_Util_Filter::removeDirectoryFromWhitelist(realpath(dirname(__FILE__) . '/../../src/VIH/'), '-tpl.php');

class AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('VIH_Tests');

        $tests = array(
            'Kortekurser',
            'Langekurser',
            'Tilmelding',
            'Materialebestilling',
            'Betaling'
        );

        foreach ($tests as $test) {
            require_once $test . '/AllTests.php';
            $suite->addTest(call_user_func(array($test.'_AllTests', 'suite')));
        }

        return $suite;
    }
}

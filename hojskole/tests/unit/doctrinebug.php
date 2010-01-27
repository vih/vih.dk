<?php
set_include_path(dirname(__FILE__) . '/../src/' . PATH_SEPARATOR . get_include_path());

define('DB_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'sandbox.db');
define('DSN', 'sqlite:///' . DB_PATH);

require_once 'Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));
require 'Ilib/ClassLoader.php';

Doctrine_Manager::connection(DSN, 'sandbox');

try {
    Doctrine::createTablesFromArray(array('VIH_Model_Course', 'VIH_Model_Course_Period', 'VIH_Model_Course_SubjectGroup', 'VIH_Model_Subject', 'VIH_Model_Course_SubjectGroup_Subject', 'VIH_Model_Course_Registration', 'VIH_Model_Course_Registration_Subject'));
} catch (Exception $e) {

}

$course1 = new VIH_Model_Course();
$course1->navn = 'Course 1';

$period1 = new VIH_Model_Course_Period();
$period1->name = 'Period 1';
$period1->Course = $course1;
$period1->save();

$period2 = new VIH_Model_Course_Period();
$period2->name = 'Period 2';
$period2->Course = $course1;
$period2->save();

$group1 = new VIH_Model_Course_SubjectGroup();
$group1->name = 'SubjectGroup 1';
$group1->Period = $period1;

$subject1 = new VIH_Model_Subject();
$subject1->navn = 'Subject 1';

$subject2 = new VIH_Model_Subject();
$subject2->navn = 'Subject 2';

$group1->Subjects[] = $subject1;
$group1->Subjects[] = $subject2;

$group1->save();

$group2 = new VIH_Model_Course_SubjectGroup();
$group2->name = 'SubjectGroup 2';
$group2->Period = $period2;

$subject3 = new VIH_Model_Subject();
$subject3->navn = 'Subject 3';

$group1->Subjects[] = $subject1;
$group1->Subjects[] = $subject2;
$group1->Subjects[] = $subject3;
$group1->save();

$subject4 = new VIH_Model_Subject();
$subject4->navn = 'Subject 4';
$subject4->save();

$course1->SubjectGroups[] = $group1;
$course1->SubjectGroups[] = $group2;

$course1->save();

$registrar = new VIH_Model_Course_Registration();
$registrar->Course = $course1;
$registrar->vaerelse = 'test';
$registrar->Subjects[] = $subject1;
$registrar->Subjects[] = $subject3;
$registrar->save();

echo '<h2>Registar subjects</h2>';
foreach ($registrar->Subjects as $subject) {
    echo $subject->navn;
}

echo '<h2>Registar reopened subjects</h2>';
$reopend = Doctrine::getTable('VIH_Model_Course_Registration')->findOneById($registrar->id);
foreach ($reopend->Subjects as $subject) {
    echo $subject->navn;
}

$registrar3 = new VIH_Model_Course_Registration();
$registrar3->Course = $course1;
$registrar3->vaerelse = 'test';
//$registrar3->Subjects;
$registrar3->save();

$reop = Doctrine::getTable('VIH_Model_Course_Registration')->findOneById($registrar3->id);
$reop->vaerelse = 1;
$reop->save();

$reopend = Doctrine::getTable('VIH_Model_Course_Registration')->findOneById($reop->id);
$reopend->Subjects[] = $subject1;
$reopend->save();

echo '<h2>Registar3 reopened subjects</h2>';
foreach ($reopend->Subjects as $subject) {
    echo $subject->navn;
}


$reopen = Doctrine::getTable('VIH_Model_Course_Registration')->findOneById($reopend->id);
$reopen->vaerelse = 1;
$reopen->save();

echo '<h2>Registar3 reopened second time subjects</h2>';
foreach ($reopend->Subjects as $subject) {
    echo $subject->navn;
}



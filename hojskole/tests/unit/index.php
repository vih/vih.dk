<?php
set_include_path(dirname(__FILE__) . '/../src/' . PATH_SEPARATOR . get_include_path());

define('DB_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'sandbox.db');
//define('DSN', 'sqlite:///' . DB_PATH);
define('DSN', 'mysql://root:klani@localhost/vih');

set_include_path(dirname(__FILE__) . '/../src/' . PATH_SEPARATOR . get_include_path());


require_once 'Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));
require 'Ilib/ClassLoader.php';

Doctrine_Manager::connection(DSN, 'sandbox');

//Doctrine_Manager::getInstance()->setAttribute('model_loading', 'conservative');

// Course hasMany SubjectGroups
// Course hasMany Registrations
// Registration hasOne Course
// SubjectGroup hasMany Subjects
// Subject hasMany SubjectGroups
// Period hasOne Course
// Course hasMany Periods
//$models = Doctrine::loadModels('VIH');


try {
    Doctrine::createTablesFromArray(array('VIH_Model_Course', 'VIH_Model_Course_Period', 'VIH_Model_Course_SubjectGroup', 'VIH_Model_Subject', 'VIH_Model_Course_SubjectGroup_Subject', 'VIH_Model_Course_Registration', 'VIH_Model_Course_Registration_Subject'));
} catch (Exception $e) {

}

$course1 = new VIH_Model_Course();
$course1->navn = 'Course 1';
$course->dato_start = '2008-08-17';
$course->dato_end = '2008-08-17';

$period1 = new VIH_Model_Course_Period();
$period1->name = 'Period 1';
$period1->date_start = '2008-08-17';
$period1->date_end = '2008-10-20';
$period1->Course = $course1;
$period1->save();

$period2 = new VIH_Model_Course_Period();
$period2->name = 'Period 2';
$period1->date_start = '2008-10-20';
$period1->date_end = '2008-12-20';
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

$registrar1 = new VIH_Model_Course_Registration();
$registrar1->Course = $course1;
$registrar1->vaerelse = 'test';
$registrar1->Subjects[] = $subject1;
$registrar1->Subjects[] = $subject2;
$registrar1->Subjects[] = $subject4; // cannot save because not in any group, which is perfect
$registrar1->save();

// listing the registrars subjects
echo '<h2>Registar0 subjects</h2>';
foreach ($registrar->Subjects as $subject) {
    echo $subject->navn;
}
echo '<h2>Registar1 subjects</h2>';
foreach ($registrar1->Subjects as $subject) {
    echo $subject->navn;
}
// listing all registrations on a subject on a particular course
echo '<h2>Registrations on a subject on a particular course in a particular period</h2>';


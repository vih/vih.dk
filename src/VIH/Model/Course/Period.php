<?php
class VIH_Model_Course_Period extends Doctrine_Record
{
    public function setTableDefinition()
    {
        //$this->setTableName('langtkursus_fag_periode ');
        $this->hasColumn('name', 'string', 255);
        $this->hasColumn('description', 'string', 65555);
        $this->hasColumn('course_id', 'integer');
        $this->hasColumn('date_start', 'date');
        $this->hasColumn('date_end', 'date');
    }

    public function setUp()
    {
        $this->hasOne('VIH_Model_Course as Course', array('local' => 'course_id', 'foreign' => 'id'));
        $this->hasMany('VIH_Model_Course_Registration_Subject as RegistrationSubjects', array('local' => 'id', 'foreign' => 'period_id'));
    }

    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function getDescription()
    {
        return $this->description;
    }

    function getDateStart()
    {
        return new Date($this->date_start);
    }

    function getDateEnd()
    {
        return new Date($this->date_end);
    }

}
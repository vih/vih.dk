<?php
class VIH_Model_Course_SubjectGroup extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->hasColumn('name', 'string', 255);
        $this->hasColumn('description', 'string', 65555);
        $this->hasColumn('elective_course', 'integer', 1);
        $this->hasColumn('period_id', 'integer');
        $this->hasColumn('course_id', 'integer');
    }

    public function setUp()
    {
        $this->hasOne('VIH_Model_Course_Period as Period', array('local'   => 'period_id',
                                                                 'foreign' => 'id'));

        $this->hasOne('VIH_Model_Course as Course', array('local'   => 'course_id',
                                                          'foreign' => 'id'));

        $this->hasMany('VIH_Model_Subject as Subjects', array('refClass' => 'VIH_Model_Course_SubjectGroup_Subject',
                                                              'local'    => 'subject_group_id',
                                                              'foreign'  => 'subject_id'));
        $this->hasMany('VIH_Model_Course_Registration_Subject as RegistrationSubjects', array('local' => 'id',
                                                                                              'foreign' => 'subjectgroup_id'));
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

    function isElectiveCourse()
    {
        return (string)$this->elective_course;
    }

}
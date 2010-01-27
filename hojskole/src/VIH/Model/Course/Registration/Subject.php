<?php
class VIH_Model_Course_Registration_Subject extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->hasColumn('registration_id', 'integer', null);
        $this->hasColumn('subject_id', 'integer', null);
        $this->hasColumn('period_id', 'integer', null);
        $this->hasColumn('subjectgroup_id', 'integer', null);
        $this->hasColumn('id', 'integer', null, array('primary' => true));
    }

    public function setUp()
    {
        $this->hasOne('VIH_Model_Course_Registration as Registration', array('local'   => 'registration_id',
                                                                             'foreign' => 'id'));

        $this->hasOne('VIH_Model_Subject as Subject', array('local'   => 'subject_id',
                                                            'foreign' => 'id'));
        $this->hasOne('VIH_Model_Course_Period as Period', array('local' => 'period_id',
                                                                 'foreign' => 'id'));

        $this->hasOne('VIH_Model_Course_SubjectGroup as SubjectGroup', array('local' => 'subjectgroup_id',
                                                                             'foreign' => 'id'));

    }
}
<?php
class VIH_Model_Course_SubjectGroup_Subject extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->hasColumn('subject_group_id', 'integer', null, array('primary' => true));
        $this->hasColumn('subject_id', 'integer', null, array('primary' => true));
    }

    public function setUp()
    {
        $this->hasOne('VIH_Model_Course_SubjectGroup as SubjectGroup', array('local'   => 'subject_group_id',
                                                                             'foreign' => 'id'));

        $this->hasOne('VIH_Model_Subject as Subject', array('local'   => 'subject_id',
                                                            'foreign' => 'id'));
    }
}
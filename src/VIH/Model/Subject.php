<?php
class VIH_Model_Subject extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('langtkursus_fag');
        $this->hasColumn('identifier', 'string', 255);
        $this->hasColumn('date_created', 'timestamp');
        $this->hasColumn('date_updated', 'timestamp');
        $this->hasColumn('navn', 'string', 255);
        $this->hasColumn('title', 'string', 255);
        $this->hasColumn('keywords', 'string');
        $this->hasColumn('description', 'string');
        $this->hasColumn('beskrivelse', 'string');
        $this->hasColumn('fag_gruppe_id', 'integer', 4);
        $this->hasColumn('pic_id', 'integer', 4);
        $this->hasColumn('published', 'boolean');
        $this->hasColumn('valgfag', 'boolean');
        $this->hasColumn('kort_beskrivelse', 'string');
        $this->hasColumn('udvidet_beskrivelse', 'string');
        $this->hasColumn('active', 'boolean');
    }

    public function setUp()
    {
        //$this->actAs('SoftDelete');
        $this->hasMany(
            'VIH_Model_Course_SubjectGroup as SubjectGroups',
            array(
                'refClass' => 'VIH_Model_Course_SubjectGroup_Subject',
                'local'    => 'subject_id',
                'foreign'  => 'subject_group_id'
            )
        );

        $this->hasMany(
            'VIH_Model_Course_Registration as Registrations',
            array(
                'refClass' => 'VIH_Model_Course_Registration_Subject',
                'local'    => 'subject_id',
                'foreign'  => 'registration_id'
            )
        );
        $this->actAs('Timestampable', array('created' => array('name'    =>  'date_created',
                                                               'type'    =>  'timestamp',
                                                               'format'  =>  'Y-m-d H:i:s',
                                                               'disabled' => false,
                                                               'options' =>  array()),
                                            'updated' =>  array('name'    =>  'date_updated',
                                                                'type'    =>  'timestamp',
                                                                'format'  =>  'Y-m-d H:i:s',
                                                                'disabled' => false,
                                                                'options' =>  array())));
    }

    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->navn;
    }
}
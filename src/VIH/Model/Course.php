<?php
class VIH_Model_Course extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('langtkursus');
        $this->hasColumn('navn', 'string', 255);
        //$this->hasColumn('version', 'integer', 11);
        $this->hasColumn('navn', 'string', 255);
        $this->hasColumn('title', 'string', 255);
        $this->hasColumn('ugeantal', 'integer', 4);
        $this->hasColumn('dato_start', 'date');
        $this->hasColumn('dato_slut', 'date');
        $this->hasColumn('kort_beskrivelse', 'string');
        $this->hasColumn('description', 'string');
        $this->hasColumn('keywords', 'string');
        $this->hasColumn('lang_beskrivelse', 'string');
        $this->hasColumn('beskrivelse', 'string');
        $this->hasColumn('tema', 'string');
        $this->hasColumn('ugepris', 'integer', 4);
        $this->hasColumn('materialepris', 'integer', 4);
        $this->hasColumn('rejsedepositum', 'integer', 4);
        $this->hasColumn('rejsepris', 'integer', 4);
        $this->hasColumn('noegledepositum', 'integer', 4);
        $this->hasColumn('depositum', 'integer', 4);
        $this->hasColumn('pris_uge', 'float');
        $this->hasColumn('pris_materiale', 'float');
        $this->hasColumn('pris_rejsedepositum', 'float');
        $this->hasColumn('pris_rejserest', 'integer', 4);
        $this->hasColumn('pris_rejselinje', 'float');
        $this->hasColumn('pris_noegledepositum', 'float');
        $this->hasColumn('pris_tilmeldingsgebyr', 'float');
        $this->hasColumn('published', 'boolean');
        $this->hasColumn('tekst_diplom', 'string');
        $this->hasColumn('active', 'boolean');
        $this->hasColumn('date_created', 'timestamp');
        $this->hasColumn('date_updated', 'timestamp');
    }

    public function setUp()
    {
        //$this->actAs('SoftDelete');
        //$this->actAs('Versionable');
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

        $this->hasMany('VIH_Model_Course_Period as Periods', array('local' => 'id',
                                                                   'foreign' => 'course_id'));
        $this->hasMany('VIH_Model_Course_SubjectGroup as SubjectGroups', array('local' => 'id',
                                                                               'foreign' => 'course_id'));
    }
    
    function getName()
    {
        return $this->navn;
    }
    
    function getId()
    {
        return $this->id;
    }
}
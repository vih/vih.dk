<?php
class VIH_Model_Course_Registration extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('langtkursus_tilmelding');
        $this->hasColumn('kursus_id', 'integer');
        $this->hasColumn('adresse_id', 'integer');
        $this->hasColumn('vaerelse', 'string', 255);
        $this->hasColumn('cpr', 'string', 15);
        $this->hasColumn('kontakt_adresse_id', 'integer');
        $this->hasColumn('uddannelse', 'integer');
        $this->hasColumn('betaling', 'integer');
        $this->hasColumn('ryger', 'string', 255);
        $this->hasColumn('fag_id', 'integer');
        $this->hasColumn('besked', 'string');
        $this->hasColumn('session_id', 'string', 255);
        $this->hasColumn('ip', 'string', 255);
        $this->hasColumn('nationalitet', 'string', 255);
        $this->hasColumn('pris_rejserest', 'integer', 4);
        $this->hasColumn('ugeantal', 'integer', 4);
        $this->hasColumn('dato_start', 'date');
        $this->hasColumn('dato_slut', 'date');
        $this->hasColumn('pris_tilmeldingsgebyr', 'integer', 4);
        $this->hasColumn('pris_materiale', 'integer', 4);
        $this->hasColumn('pris_uge', 'integer', 4);
        $this->hasColumn('pris_rejsedepositum', 'integer', 4);
        $this->hasColumn('pris_rejselinje', 'integer', 4);
        $this->hasColumn('pris_noegledepositum', 'integer', 4);
        $this->hasColumn('kommune', 'string', 255);
        $this->hasColumn('elevstotte', 'float', null);
        $this->hasColumn('ugeantal_elevstotte', 'integer', 4);
        $this->hasColumn('kompetencestotte', 'float', null);
        $this->hasColumn('statsstotte', 'integer', 4);
        $this->hasColumn('kommunestotte', 'float', null);
        $this->hasColumn('aktiveret_tillaeg', 'float', null);
        $this->hasColumn('pris_afbrudt_ophold', 'integer', 4);
        $this->hasColumn('faerdigbetalt', 'integer', 4);
        $this->hasColumn('status_key', 'integer', 4);
        $this->hasColumn('active', 'integer', 4, array('default' => '1'));
        $this->hasColumn('code', 'string', 255);
        $this->hasColumn('pic_id', 'integer');
        $this->hasColumn('sex', 'integer', 4);
    }

    public function setUp()
    {
        $this->hasOne('VIH_Model_Course as Course', array('local'   => 'kursus_id',
                                                          'foreign' => 'id'));

        $this->hasMany('VIH_Model_Subject as Subjects', array('refClass' => 'VIH_Model_Course_Registration_Subject',
                                                             'local'    => 'registration_id',
                                                             'foreign'  => 'subject_id'));

        $this->actAs('Timestampable', array('created' => array('name'     =>  'date_created',
                                                               'type'     =>  'timestamp',
                                                               'format'   =>  'Y-m-d H:i:s',
                                                               'disabled' => false,
                                                               'options'  =>  array()),
                                            'updated' =>  array('name'     =>  'date_updated',
                                                                'type'     =>  'timestamp',
                                                                'format'   =>  'Y-m-d H:i:s',
                                                                'disabled' => false,
                                                                'options'  =>  array())));
    }
    
    function getCourseId()
    {
        return $this->kursus_id;
    }
}
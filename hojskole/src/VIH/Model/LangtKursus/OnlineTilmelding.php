<?php
class VIH_Model_LangtKursus_OnlineTilmelding extends VIH_Model_LangtKursus_Tilmelding
{
    protected $session_id;

    /**
     * Constructor
     *
     * @param string $session_id Et unikt genkendelsesid.
     */
    public function __construct($session_id)
    {
        $this->session_id = $session_id;

        if (!$this->cleanUp()) {
            throw new Exception('Could not clean up the registrations');
        }

        $this->init();
    }

    private function init()
    {
        $db = new DB_Sql;
        $db->query("SELECT id FROM langtkursus_tilmelding WHERE session_id = '" . $this->session_id . "'");
        if ($db->nextRecord()) {
            parent::__construct($db->f('id'));
        }
    }

    /**
     * Funktionen skal rydde op i gamle tilmeldinger. B�r k�res fra construktor.
     * Funktionen skal bruge cancel() og ikke delete(), da tilmeldingernes status
     * blot skal s�ttes til annulleret som hvis det var brugeren selv der annullerede
     * og ikke slettet.
     */
    public function cleanUp()
    {
        return true;
    }

    public function confirm()
    {
        if ($this->id <= 0) {
            return false;
        }
        if (!$this->setStatus('reserveret')) {
            return false;
        }

        return true;
    }

    public function cancel()
    {
        if ($this->id <= 0) {
            return false;
        }
        if (!$this->setStatus('annulleret')) {
            return false;
        }
        return true;
    }

    public function start()
    {
        Doctrine_Manager::connection(DB_DSN);
        $tilmelding = Doctrine::getTable('VIH_Model_Course_Registration')->findOneBySessionId($this->session_id);
        if ($tilmelding === false) {
            $tilmelding = new VIH_Model_Course_Registration;
        }
        $tilmelding->session_id = $this->session_id;
        $tilmelding->ip = $this->getIpAddress();         
        $tilmelding->save();
        return true;
    }
    
    private function getIpAddress() 
    {
        if (!empty($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        } else {
            return 'n/a';
        } 
    }
}
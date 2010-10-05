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
     * Cleans up old subscriptions
     * NOTICE: Use cancel() so the subscriptions is only cancelled and not deleted
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

    public function start($kursus_id)
    {
        $tilmelding = Doctrine::getTable('VIH_Model_Course_Registration')->findOneBySessionId($this->session_id);
        if ($tilmelding === false) {
            $tilmelding = new VIH_Model_Course_Registration;
        }
        $tilmelding->session_id = $this->session_id;
        $tilmelding->ip = $this->getIpAddress();
        $tilmelding->kursus_id = $kursus_id;
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
<?php
/**
 * Used for online registration
 *
 * @author Lars Olesen <lars@legestue.net>
 */
class VIH_Model_KortKursus_OnlineTilmelding extends VIH_Model_KortKursus_Tilmelding
{
    protected $session_id;

    function __construct($session_id)
    {
        $this->session_id = $session_id;
        $tilmelding_id = 0;

        $this->cleanUp();

        $db = new DB_Sql;

        $db->query("SELECT id FROM kortkursus_tilmelding WHERE session_id = '" . $session_id . "' AND active = 1 AND (status_key = ".$this->getStatusKey('undervejs')." OR ".$this->getStatusKey('reserveret').")");
        if ($db->nextRecord()) {
            $tilmelding_id = $db->f('id');
        }

        if ($tilmelding_id > 0) {
            parent::__construct($tilmelding_id);
        }
    }

    /**
     * Starts the subscription
     * Notice: Use this otherwise earlier saved stuff will be deleted when going back in the form
     *
     * @return inserted id on success
     */
    function start($input)
    {
        if ($this->id == 0 OR !empty($this->status[$this->get('status')]) AND $this->status[$this->get('status')] == 'tilmeldt') {
            $sql_type = "INSERT INTO ";
            $sql_end = ", date_created = NOW(), session_id = '" . $this->session_id . "' ";
        } else {
            $sql_type = "UPDATE ";
            $sql_end = " WHERE session_id = '" . $this->session_id ."'";
        }
        $sql = $sql_type . "kortkursus_tilmelding
            SET
                status_key = ".$this->getStatusKey('undervejs').",
                kortkursus_id = ".$input['kursus_id'].",
                antal_deltagere = ".$input['antal_deltagere'].",
                ip = '" . vih_get_ip_address() . "',
                date_updated = NOW()
                " . $sql_end;

        $db = new DB_Sql;
        $db->query($sql);

        if ($this->id == 0) {
            $this->id = $db->insertedId();
        }

        $this->load();

        return $this->id;

    }

    /**
     * Confirms a subscription to reserve a spot on the course
     *
     * @return 1 on success
     */
    function confirm()
    {
        if ($this->id <= 0) {
            return false;
        }
        if (!$this->setStatus('reserveret')) {
            return false;
        }
        //session_destroy();
        return true;
    }

    /**
     * Metoden bruges under tilmeldingen til at annullere en tilmelding.
     *
     * @return 1 on success
     */
    function cancel()
    {
        if ($this->id <= 0) {
            return false;
        }
        if (!$this->setStatus('annulleret')) {
            return false;
        }
        //session_destroy();
        return true;
    }


    /**
     * Cleans up old subscriptions
     *
     * NOTICE: Use cancel() and not delete()
     *
     * @return 1 on success
     */
    function cleanUp()
    {
        $db = new DB_Sql;

        $db->query("SELECT id, DATE_ADD(date_updated, INTERVAL 1 HOUR) AS date_created FROM kortkursus_tilmelding
            WHERE DATE_ADD(date_updated, INTERVAL 1 HOUR) < NOW()
                AND (status_key = '".$this->getStatusKey('undervejs')."' OR status_key = '".$this->getStatusKey('ikke tilmeldt')."') AND active = 1");
        while ($db->nextRecord()) {
            $tilmelding = new VIH_Model_KortKursus_Tilmelding($db->f('id'));
            $tilmelding->setStatus('annulleret');
        }
        return true;
    }

    function addDeltager()
    {
        // void
    }

}
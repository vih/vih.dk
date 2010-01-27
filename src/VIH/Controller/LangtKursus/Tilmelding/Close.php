<?php
class VIH_Controller_LangtKursus_Tilmelding_Close extends k_Controller
{
    function GET()
    {
        $db = new DB_Sql;
        $db->query('UPDATE langtkursus_tilmelding SET session_id = "" WHERE session_id = "' . $this->context->name . '"');

        throw new k_http_Redirect($this->url('/langekurser'));
    }
}
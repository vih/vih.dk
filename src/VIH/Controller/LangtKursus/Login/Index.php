<?php
class VIH_Controller_LangtKursus_Login_Index extends k_Controller
{
    function GET()
    {
        throw new Exception('Denne side kan ikke tilgås direkte.');
    }

    function forward($name)
    {
        $next = new VIH_Controller_LangtKursus_Login_Tilmelding($this, $name);
        return $content = $next->handleRequest();
    }
}
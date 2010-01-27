<?php
class VIH_Controller_KortKursus_Login_Index extends k_Controller
{
    function GET()
    {
        return 'login';
    }

    function forward($name)
    {
        $next = new VIH_Controller_KortKursus_Login_Tilmelding($this, $name);
        return $next->handleRequest();
    }

}
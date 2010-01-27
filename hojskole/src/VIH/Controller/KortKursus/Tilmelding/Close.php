<?php

class VIH_Controller_KortKursus_Tilmelding_Close extends k_Controller
{
    function GET()
    {
        throw new k_http_Redirect($this->url('/'));
    }

}


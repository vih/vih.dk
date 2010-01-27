<?php

class VIH_Controller_KortKursus_Tilmelding_Afbryd extends k_Controller
{
    function GET()
    {
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($this->context->name);
        if (!$tilmelding->cancel()) {
            trigger_error('Der opstod en fejl, da tilmeldingen skulle afbrydes.', E_USER_ERROR);
        }

        throw new k_http_Redirect($this->url('/'));
    }

}


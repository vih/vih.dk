<?php

class VIH_Controller_KortKursus_Tilmelding_Afbryd extends k_Controller
{
    function GET()
    {
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($this->context->name);
        if (!$tilmelding->cancel()) {
            throw new Exception('Der opstod en fejl, da tilmeldingen skulle afbrydes.');
        }

        throw new k_http_Redirect($this->url('/'));
    }

}


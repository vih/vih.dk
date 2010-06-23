<?php
class VIH_Controller_KortKursus_Tilmelding_Afbryd extends k_Component
{
    function renderHtml()
    {
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($this->context->name());
        if (!$tilmelding->cancel()) {
            throw new Exception('Der opstod en fejl, da tilmeldingen skulle afbrydes.');
        }

        return new k_SeeOther($this->url('/'));
    }
}


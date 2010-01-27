<?php
/**
 * Form�let med denne fil er at afbryde en igangv�rende tilmelding.
 * Efter afbrydelsen sendes brugeren blot videre til forsiden.
 *
 * @author Lars Olesen <lars@legestue.net>
 */
class VIH_Controller_LangtKursus_Tilmelding_Afbryd extends k_Controller
{
    function GET()
    {
        $tilmelding = new VIH_Model_LangtKursus_OnlineTilmelding($this->context->name);
        if (!$tilmelding->cancel()) {
            trigger_error('Der opstod en fejl, da tilmeldingen skulle afbrydes.', E_USER_ERROR);
        }

        throw new k_http_Redirect('/langekurser');
    }
}
<?php
/**
 * Formålet med denne fil er at afbryde en igangværende tilmelding.
 * Efter afbrydelsen sendes brugeren blot videre til forsiden.
 *
 * @author Lars Olesen <lars@legestue.net>
 */
class VIH_Controller_LangtKursus_Tilmelding_Afbryd extends k_Component
{
    function renderHtml()
    {
        $tilmelding = new VIH_Model_LangtKursus_OnlineTilmelding($this->context->name());
        if (!$tilmelding->cancel()) {
            throw new Exception('Der opstod en fejl, da tilmeldingen skulle afbrydes.');
        }

        return new k_SeeOther('/langekurser');
    }
}
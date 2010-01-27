<?php
/**
 * Tilmeldingssystem til Korte Kurser
 *
 * Denne side starter tilmeldingen op. Til det har vi brug for at vide følgende:
 *
 * - kursus vedkommende vil deltage på
 * - antallet af deltagere vedkommende vil tilmelde
 *
 * Man kan både tilmelde sig kurser med og uden ledige pladser. Hvis man tilmelder
 * sig et kursus uden ledige pladser skal man kunne komme på venteliste.
 *
 * @author Lars Olesen <lars@legestue.net>
 * @version 22. januar 2006
 */

class VIH_Controller_KortKursus_Tilmelding_Index extends k_Controller
{
    function GET()
    {
        $session_id = md5($this->SESSION->getSessionId());

        throw new k_http_Redirect($this->url($session_id));
    }

    function forward($name)
    {
        $next = new VIH_Controller_KortKursus_Tilmelding_Antal($this, $name);
        $data = array('content' => $next->handleRequest());

        return $this->render('VIH/View/wrapper-tpl.php', $data);
    }

    function getKursusId()
    {
        return $this->context->name;
    }
}
<?php
/**
 * Tilmeldingssystem til Korte Kurser
 *
 * Denne side starter tilmeldingen op. Til det har vi brug for at vide fï¿½lgende:
 *
 * - kursus vedkommende vil deltage pï¿½
 * - antallet af deltagere vedkommende vil tilmelde
 *
 * Man kan bï¿½de tilmelde sig kurser med og uden ledige pladser. Hvis man tilmelder
 * sig et kursus uden ledige pladser skal man kunne komme pï¿½ venteliste.
 *
 * @author Lars Olesen <lars@legestue.net>
 * @version 22. januar 2006
 */

class VIH_Controller_KortKursus_Tilmelding_Index extends k_Component
{
    protected $template;
    protected $db_sql;

    function __construct(k_TemplateFactory $template, DB_Sql $db_sql)
    {
        $this->template = $template;
        $this->db_sql = $db_sql;
    }

    function map($name)
    {
        return 'VIH_Controller_KortKursus_Tilmelding_Antal';
    }

    function renderHtml()
    {
        $session_id = md5($this->session()->sessionId());

        return new k_SeeOther($this->url($session_id));
    }

    function wrapHtml($content)
    {
        $data = array('content' => $content);
        $tpl = $this->template->create('wrapper');
        return $tpl->render($this, $data);
    }

    function getRegistrationGateway()
    {
        return new VIH_Model_KortKursus_TilmeldingGateway($this->db_sql);
    }

    function getKursusId()
    {
        return $this->context->name();
    }
}
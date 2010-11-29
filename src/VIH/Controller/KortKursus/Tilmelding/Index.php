<?php
/**
 * Registration system for short courses
 *
 * @author Lars Olesen <lars@legestue.net>
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
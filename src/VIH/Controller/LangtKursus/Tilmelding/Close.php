<?php
class VIH_Controller_LangtKursus_Tilmelding_Close extends k_Component
{
    protected $template;
    protected $db;

    function __construct(k_TemplateFactory $template, DB_Sql $db)
    {
        $this->template = $template;
        $this->db = $db;
    }

    function renderHtml()
    {
        $this->db->query('UPDATE langtkursus_tilmelding SET session_id = "" WHERE session_id = "' . $this->context->name() . '"');

        return new k_SeeOther($this->url('/langekurser'));
    }
}
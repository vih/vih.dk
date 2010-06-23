<?php
class VIH_Controller_LangtKursus_Tilmelding_Index extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function map($name)
    {
        return 'VIH_Controller_LangtKursus_Tilmelding_Kontakt';
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

    function getLangtKursusId()
    {
        return $this->context->name();
    }

    function getSubjects()
    {
        return $this->context->getSubjects();
    }
}
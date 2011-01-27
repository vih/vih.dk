<?php
class VIH_Controller_KortKursus_Tilmelding_Conditions extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }
    
    function renderHtml()
    {
        $this->document->setTitle('Betalingsbetingelser');
        
        $tpl = $this->template->create('KortKursus/Tilmelding/conditions');

        return $tpl->render($this);
    }
}

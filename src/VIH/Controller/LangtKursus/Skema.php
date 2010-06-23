<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_LangtKursus_Skema extends k_Component
{
    public $i18n = array('Diskussionsfag' => 'Teori',
                         'Individuel trï¿½ning' => 'Trï¿½ning',
                         'Idrï¿½tsspeciale A' => 'Idrï¿½t A',
                         'Idrï¿½tsspeciale B' => 'Idrï¿½t B');
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $tpl = $this->template->create('LangtKursus/skema');
        return $tpl->render($this);
    }
}
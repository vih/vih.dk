<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_LangtKursus_Skema extends k_Component
{
    public $i18n = array('Diskussionsfag' => 'Teori',
                         'Individuel træning' => 'Træning',
                         'Idrætsspeciale A' => 'Idræt A',
                         'Idrætsspeciale B' => 'Idræt B');
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
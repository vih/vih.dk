<?php
class VIH_Controller_Fag_Pakker_Politi extends k_Component
{
    public $i18n = array(
        'Idræt A' => 'Outdoor Energy',
        'Idræt B' => 'Adventure',
        'Linje' => 'Politi',
        'Diskussion' => 'Almen viden'
    );

    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $this->document->setTitle('Forberedelse til politiet på Vejle Idrætshøjskole - politi');
        $this->document->meta['description'] = 'For dig der vil forberede dig til politiets optagelsesprøve. Politi forberedende linje.';
        $this->document->meta['keywords'] = 'politi, højskole, idrætshøjskole, politiets optagelsesprøve';

        $this->document->theme = 'politilinje';

        $this->document->widepicture = $this->context->getWidePictureHTML('politi');

        $tpl = $this->template->create('Fag/pakke/politi');
        return $tpl->render($this);
    }

    function getSkema()
    {
        $this->context->i18n = $this->i18n;
        return $this->context->getSkema();
    }
}
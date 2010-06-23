<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Fag_Pakker_Boldspil extends k_Component
{
    public $i18n = array(
        'Idræt A' => 'Fodbold',
        'Idræt B' => 'Volley',
        'Linje' => 'Mental challenge',
        'Idrætsfag' => 'Floorball',
        'Diskussion' => 'Det gælder livet'
    );

    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function GET()
    {
        $this->document->setTitle('Boldspil på Vejle Idrætshøjskole');
        $this->document->description = 'Du kan sammensætte en fagpakke med boldspil på Vejle Idrætshøjskole. For dig der er til boldspil og højskole.';
        $this->document->keywords = 'boldspil, højskole, idrætshøjskole';

        $this->document->theme = 'fodbold';

        $this->document->widepicture = $this->context->getWidePictureHTML('boldspil');

        $tpl = $this->template->create('Fag/pakke');
        $data = array(
            'pakke' => 'Boldspil',
            'beskrivelse' => 'For dig der er interesseret i boldspil. Du får mulighed for at prøve en lang række forskellige boldspil. Nogen kan du have i mange timer om ugen, mens du kan have andre fag i kortere perioder. Du får bedre teknik og en øget taktiske forståelse, og du vil komme til at afprøve dig selv som træner.');

        return $tpl->render($this, $data);
    }

    function getSkema()
    {
        $this->context->i18n = $this->i18n;
    	return $this->context->getSkema();
    }
}
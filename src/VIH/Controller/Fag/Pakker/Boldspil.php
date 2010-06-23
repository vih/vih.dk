<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Fag_Pakker_Boldspil extends k_Component
{
    public $i18n = array(
        'Idr�t A' => 'Fodbold',
        'Idr�t B' => 'Volley',
        'Linje' => 'Mental challenge',
        'Idr�tsfag' => 'Floorball',
        'Diskussion' => 'Det g�lder livet'
    );

    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function GET()
    {
        $this->document->setTitle('Boldspil p� Vejle Idr�tsh�jskole');
        $this->document->description = 'Du kan sammens�tte en fagpakke med boldspil p� Vejle Idr�tsh�jskole. For dig der er til boldspil og h�jskole.';
        $this->document->keywords = 'boldspil, h�jskole, idr�tsh�jskole';

        $this->document->theme = 'fodbold';

        $this->document->widepicture = $this->context->getWidePictureHTML('boldspil');

        $tpl = $this->template->create('Fag/pakke');
        $data = array(
            'pakke' => 'Boldspil',
            'beskrivelse' => 'For dig der er interesseret i boldspil. Du f�r mulighed for at pr�ve en lang r�kke forskellige boldspil. Nogen kan du have i mange timer om ugen, mens du kan have andre fag i kortere perioder. Du f�r bedre teknik og en �get taktiske forst�else, og du vil komme til at afpr�ve dig selv som tr�ner.');

        return $tpl->render($this, $data);
    }

    function getSkema()
    {
        $this->context->i18n = $this->i18n;
    	return $this->context->getSkema();
    }
}
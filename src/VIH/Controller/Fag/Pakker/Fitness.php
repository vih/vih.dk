<?php
class VIH_Controller_Fag_Pakker_Fitness extends k_Component
{
    public $i18n = array(
        'Idræt A' => 'Fitnessinstruktør',
        'Idræt B' => 'Spinning, pump og boksning',
        'Linje' => 'Body og mind',
        'Idrætsfag' => 'Dans',
        'Diskussion' => 'Det gælder livet'
    );

    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $this->document->setTitle('Fitness på Vejle Idrætshøjskole');
        $this->document->meta['description'] = 'Hvis du vælger en fagpakke med fitness på Vejle Idrætshøjskole, kommer du til at få et bredt indblik i fitnessverden.';
        $this->document->meta['keywords'] = 'fitness, aerobic, højskole, idrætshøjskole';


        $this->document->theme = 'fitness';
        $this->document->widepicture = $this->context->getWidePictureHTML('fitness');

        $tpl = $this->template->create('Fag/pakke');
        $data = array(
            'pakke' => 'Fitness',
            'beskrivelse' => 'For dig der gerne vil kombinere din interesse for fitness og sundhed med et højskoleophold. Du får indblik i en lang række forskellige træningsformer, og du har mulighed for at gå i dybden med teorien bag ved træningsformerne. Hvis du overvejer uddannelse indenfor idræts- eller sundhedssektoren som sygeplejerske, ergoterapeut, fysioterapeut, læge-, lærer- eller idrætsstudie, kan en række af fagene i idrætspaletten være en god forberedelse.');
        return $tpl->render($this, $data);

    }

    function getSkema()
    {
        $this->context->i18n = $this->i18n;
        return $this->context->getSkema();
    }
}
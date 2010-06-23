<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Fag_Pakker_Fitness extends k_Component
{
    public $i18n = array(
        'Idr�t A' => 'Fitnessinstrukt�r',
        'Idr�t B' => 'Spinning, pump og boksning',
        'Linje' => 'Body og mind',
        'Idr�tsfag' => 'Dans',
        'Diskussion' => 'Det g�lder livet'
    );

    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function GET()
    {
        $this->document->setTitle('Fitness p� Vejle Idr�tsh�jskole');
        $this->document->description = 'Hvis du v�lger en fagpakke med fitness p� Vejle Idr�tsh�jskole, kommer du til at f� et bredt indblik i fitnessverden.';
        $this->document->keywords = 'fitness, aerobic, h�jskole, idr�tsh�jskole';


        $this->document->theme = 'fitness';
        $this->document->widepicture = $this->context->getWidePictureHTML('fitness');

        $tpl = $this->template->create('Fag/pakke');
        $data = array(
            'pakke' => 'Fitness',
            'beskrivelse' => 'For dig der gerne vil kombinere din interesse for fitness og sundhed med et h�jskoleophold. Du f�r indblik i en lang r�kke forskellige tr�ningsformer, og du har mulighed for at g� i dybden med teorien bag ved tr�ningsformerne. Hvis du overvejer uddannelse indenfor idr�ts- eller sundhedssektoren som sygeplejerske, ergoterapeut, fysioterapeut, l�ge-, l�rer- eller idr�tsstudie, kan en r�kke af fagene i idr�tspaletten v�re en god forberedelse.');
        return $tpl->render($this, $data);

    }

    function getSkema()
    {
        $this->context->i18n = $this->i18n;
        return $this->context->getSkema();
    }
}
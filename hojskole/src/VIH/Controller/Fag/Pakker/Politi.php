<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Fag_Pakker_Politi extends k_Controller
{
    public $i18n = array(
        'Idræt A' => 'Outdoor Energy',
        'Idræt B' => 'Adventure',
        'Linje' => 'Politi',
        'Diskussion' => 'Almen viden'
    );

    function GET()
    {
        $this->document->title = 'Forberedelse til politiet på Vejle Idrætshøjskole - politi';
        $this->document->description = 'For dig der vil forberede dig til politiets optagelsesprøve. Politi forberedende linje.';
        $this->document->keywords = 'politi, højskole, idrætshøjskole, politiets optagelsesprøve';

        $this->document->theme = 'politilinje';

        $this->document->widepicture = $this->context->getWidePictureHTML('politi');

        $data = array(
            'pakke' => 'Politi',
            'beskrivelse' => 'For dig som drømmer om at komme ind på politiskolen. Kurset forbereder dig til at kunne bestå Politiets optagelsesprøve og være klar til de udfordringer der venter på politiskolen og ved Politiet. Politikurset indeholder undervisning og testning indenfor alle de områder som er indeholdt i politiets optagelsesprøve. Dertil vil der være oplæg ved ansatte fra Politiet, oplæg om politiskolen,  bassinprøve m.m. Udover den målrettede politiundervisning er der mulighed for at vælge et idrætsspeciale og valgfag efter egen interesse. Kurset er planlagt på baggrund af mange års erfaringer, samt løbende dialog med Politiet.');
        return $this->render('VIH/View/Fag/pakke.tpl.php', $data);
    }

    function getSkema()
    {
        $this->context->i18n = $this->i18n;
        return $this->context->getSkema();
    }
}
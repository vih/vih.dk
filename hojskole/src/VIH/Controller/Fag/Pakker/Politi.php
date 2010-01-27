<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Fag_Pakker_Politi extends k_Controller
{
    public $i18n = array(
        'Idr�t A' => 'Outdoor Energy',
        'Idr�t B' => 'Adventure',
        'Linje' => 'Politi',
        'Diskussion' => 'Almen viden'
    );

    function GET()
    {
        $this->document->title = 'Forberedelse til politiet p� Vejle Idr�tsh�jskole - politi';
        $this->document->description = 'For dig der vil forberede dig til politiets optagelsespr�ve. Politi forberedende linje.';
        $this->document->keywords = 'politi, h�jskole, idr�tsh�jskole, politiets optagelsespr�ve';

        $this->document->theme = 'politilinje';

        $this->document->widepicture = $this->context->getWidePictureHTML('politi');

        $data = array(
            'pakke' => 'Politi',
            'beskrivelse' => 'For dig som dr�mmer om at komme ind p� politiskolen. Kurset forbereder dig til at kunne best� Politiets optagelsespr�ve og v�re klar til de udfordringer der venter p� politiskolen og ved Politiet. Politikurset indeholder undervisning og testning indenfor alle de omr�der som er indeholdt i politiets optagelsespr�ve. Dertil vil der v�re opl�g ved ansatte fra Politiet, opl�g om politiskolen,  bassinpr�ve m.m. Udover den m�lrettede politiundervisning er der mulighed for at v�lge et idr�tsspeciale og valgfag efter egen interesse. Kurset er planlagt p� baggrund af mange �rs erfaringer, samt l�bende dialog med Politiet.');
        return $this->render('VIH/View/Fag/pakke.tpl.php', $data);
    }

    function getSkema()
    {
        $this->context->i18n = $this->i18n;
        return $this->context->getSkema();
    }
}
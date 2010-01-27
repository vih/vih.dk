<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Fag_Pakker_Outdoor extends k_Controller
{
    public $i18n = array(
        'Idr�t A' => 'Outdoor Energy',
        'Idr�t B' => 'Adventure',
        'Linje' => 'Mental challenge',
        'Diskussion' => 'Det g�lder livet'
    );

    function GET()
    {
        $this->document->title = 'Outdoor fagpakke p� Vejle Idr�tsh�jskole: en blanding af adventure, friluftsliv og outdoor';
        $this->document->description = 'Du kan v�lge outdoor som en fagpakke p� Vejle Idr�tsh�jskole. For dig der er til adventure, friluftsliv og outdoor og h�jskole.';
        $this->document->keywords = 'outdoor, adventure, friluftsliv, h�jskole, idr�tsh�jskole';

        $this->document->theme = 'adventure';

        $this->document->widepicture = $this->context->getWidePictureHTML('outdoor');

        $data = array(
            'pakke' => 'Outdoor',
            'beskrivelse' => 'Med udgangspunkt i omr�dets fremragende natur udbyder vi flere fag indenfor outdoor, med mulighed bl.a. for fysisk tr�ning, tekniske f�rdigheder, oplevelser, teamtr�ning m.m. Har du mod p� udfordringer indenfor Outdoor, tilbyder vi fire fag, l�s yderlig under linje og specialer. Fagene er Outdoor Energy, Adventure, Mental Challenge og Teambuilder.');
        return $this->render('VIH/View/Fag/pakke.tpl.php', $data);
    }

    function getSkema()
    {
        $this->context->i18n = $this->i18n;
        return $this->context->getSkema();
    }
}
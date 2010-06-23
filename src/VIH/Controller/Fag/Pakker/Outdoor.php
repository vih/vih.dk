<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Fag_Pakker_Outdoor extends k_Component
{
    public $i18n = array(
        'Idræt A' => 'Outdoor Energy',
        'Idræt B' => 'Adventure',
        'Linje' => 'Mental challenge',
        'Diskussion' => 'Det gælder livet'
    );
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function GET()
    {
        $this->document->setTitle('Outdoor fagpakke på Vejle Idrætshøjskole: en blanding af adventure, friluftsliv og outdoor');
        $this->document->description = 'Du kan vælge outdoor som en fagpakke på Vejle Idrætshøjskole. For dig der er til adventure, friluftsliv og outdoor og højskole.';
        $this->document->keywords = 'outdoor, adventure, friluftsliv, højskole, idrætshøjskole';

        $this->document->theme = 'adventure';

        $this->document->widepicture = $this->context->getWidePictureHTML('outdoor');

        $data = array(
            'pakke' => 'Outdoor',
            'beskrivelse' => 'Med udgangspunkt i områdets fremragende natur udbyder vi flere fag indenfor outdoor, med mulighed bl.a. for fysisk træning, tekniske færdigheder, oplevelser, teamtræning m.m. Har du mod på udfordringer indenfor Outdoor, tilbyder vi fire fag, læs yderlig under linje og specialer. Fagene er Outdoor Energy, Adventure, Mental Challenge og Teambuilder.');

        $tpl = $this->template->create('Fag/pakke');
        return $tpl->render($this, $data);
    }

    function getSkema()
    {
        $this->context->i18n = $this->i18n;
        return $this->context->getSkema();
    }
}
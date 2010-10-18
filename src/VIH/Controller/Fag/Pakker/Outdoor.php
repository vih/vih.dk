<?php
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

    function renderHtml()
    {
        $this->document->setTitle('Outdoor fagpakke på Vejle Idrætshøjskole: en blanding af adventure, friluftsliv og outdoor');
        $this->document->meta['description'] = 'Du kan vælge outdoor som en fagpakke på Vejle Idrætshøjskole. For dig der er til adventure, friluftsliv og outdoor og højskole.';
        $this->document->meta['keywords'] = 'outdoor, adventure, friluftsliv, højskole, idrætshøjskole';

        $this->document->theme = 'adventure';

        $this->document->widepicture = $this->context->getWidePictureHTML('outdoor');

        $data = array(
            'pakke' => 'Outdoor',
            'beskrivelse' => 'Med Vejle Idrætshøjskoles unikke placering lige ud til Nørreskoven og tæt ved Vejle Fjord har vi selvfølgelig en lang række spændende og udfordrende fag på programmet inden for Outdoor-området. Er du til fysisk træning med naturen som træningsrum kan du vælge mellem træningsfagene Outdoor Energy, Adventure Race og Cykling, Marathon og Triathlon. Er du til frisk luft og oplevelser i naturen kan du endvidere vælge mellem fagene Adventure Forest, Adventure Maritim og Friluftsliv. Læs om fagene under Idrætsfag og Kompetencelinjer i menuen til højre på siden.');

        $tpl = $this->template->create('Fag/pakke');
        return $tpl->render($this, $data);
    }

    function getSkema()
    {
        $this->context->i18n = $this->i18n;
        return $this->context->getSkema();
    }
}
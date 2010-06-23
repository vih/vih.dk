<?php
class VIH_Controller_Om_Persondata extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'Politik om persondata';
        $meta['description'] = 'Her finder du kontaktinformation om hï¿½jskolen. Adresse, telefonnumre og e-mail-adresser pï¿½ det administrative personale pï¿½ skolens kontor.';
        $meta['keywords'] = 'Vejle, idrï¿½tshï¿½jskole, jyske, idrï¿½tsskole, beliggenhed, telefonnummer, kontakt, ï¿½bningstider, elevtelefon, administrativt personale, markedsfï¿½ring, marketing, annoncer, forretningsfï¿½rer, forstander, e-post, epost, email, e-mail, adresseliste, skolens kontor, telefon, telefontid';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $tpl = $this->template->create('Om/persondata');
        return $tpl->render($this);
    }
}
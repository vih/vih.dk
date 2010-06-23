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
        $meta['description'] = 'Her finder du kontaktinformation om højskolen. Adresse, telefonnumre og e-mail-adresser på det administrative personale på skolens kontor.';
        $meta['keywords'] = 'Vejle, idrætshøjskole, jyske, idrætsskole, beliggenhed, telefonnummer, kontakt, åbningstider, elevtelefon, administrativt personale, markedsføring, marketing, annoncer, forretningsfører, forstander, e-post, epost, email, e-mail, adresseliste, skolens kontor, telefon, telefontid';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $tpl = $this->template->create('Om/persondata');
        return $tpl->render($this);
    }
}
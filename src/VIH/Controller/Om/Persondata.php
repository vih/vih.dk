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
        $meta['description'] = 'Her finder du kontaktinformation om h�jskolen. Adresse, telefonnumre og e-mail-adresser p� det administrative personale p� skolens kontor.';
        $meta['keywords'] = 'Vejle, idr�tsh�jskole, jyske, idr�tsskole, beliggenhed, telefonnummer, kontakt, �bningstider, elevtelefon, administrativt personale, markedsf�ring, marketing, annoncer, forretningsf�rer, forstander, e-post, epost, email, e-mail, adresseliste, skolens kontor, telefon, telefontid';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $tpl = $this->template->create('Om/persondata');
        return $tpl->render($this);
    }
}
<?php
class VIH_Controller_Kontakt_Index extends k_Component
{
    public $map = array('elevchat'    => 'VIH_Controller_Kontakt_Elevchat',
                        'beliggenhed' => 'VIH_Controller_Kontakt_Beliggenhed',
    );

    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function map($name)
    {
        return $this->map[$name];
    }

    function renderHtml()
    {
        $title = 'Kontakt';
        $meta['description'] = 'Her finder du kontaktinformation om højskolen. Adresse, telefonnumre og e-mail-adresser på det administrative personale på skolens kontor.';
        $meta['keywords'] = 'Vejle, idrætshøjskole, jyske, idrætsskole, beliggenhed, telefonnummer, kontakt, åbningstider, elevtelefon, administrativt personale, markedsføring, marketing, annoncer, forretningsfører, forstander, e-post, epost, email, e-mail, adresseliste, skolens kontor, telefon, telefontid';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'kontakt';

        $tpl = $this->template->create('Kontakt/index');
        $data = array('content' => $tpl->render($this));

        $tpl = $this->template->create('wrapper');
        return $tpl->render($this, $data);
    }

    function wrapHtml($content)
    {
        $data = array('content' => $content);
        $tpl = $this->template->create('wrapper');
        return $tpl->render($this, $data);
    }
}
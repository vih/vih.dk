<?php
class VIH_Controller_Kontakt_Beliggenhed extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'Beliggenhed, rutebeskrivelse, transport';
        $meta['description'] = 'Beskrivelse af beliggenhed med kørselsvejledning med offentlige transportmidler og med bil fra større indfaldsveje og fra stationen i Vejle.';
        $meta['keywords'] = 'Vejle, idrætshøjskole, jyske, idrætsskole, beliggenhed, kommune, kort, vejbeskrivelse, kørselsvejledning, kørsel, rutebeskrivelse, hvor ligger skolen, placering, kørselsvejvisning, kørselshenvisningormation, transport, indfaldsveje, stationer, station';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $tpl = $this->template->create('Kontakt/beliggenhed');
        return $tpl->render($this);
    }
}
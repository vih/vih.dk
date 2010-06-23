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
        $meta['description'] = 'Beskrivelse af beliggenhed med kï¿½rselsvejledning med offentlige transportmidler og med bil fra stï¿½rre indfaldsveje og fra stationen i Vejle.';
        $meta['keywords'] = 'Vejle, idrï¿½tshï¿½jskole, jyske, idrï¿½tsskole, beliggenhed, kommune, kort, vejbeskrivelse, kï¿½rselsvejledning, kï¿½rsel, rutebeskrivelse, hvor ligger skolen, placering, kï¿½rselsvejvisning, kï¿½rselshenvisningormation, transport, indfaldsveje, stationer, station';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $tpl = $this->template->create('Kontakt/beliggenhed');
        return $tpl->render($this);
    }
}
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
        $meta['description'] = 'Beskrivelse af beliggenhed med k�rselsvejledning med offentlige transportmidler og med bil fra st�rre indfaldsveje og fra stationen i Vejle.';
        $meta['keywords'] = 'Vejle, idr�tsh�jskole, jyske, idr�tsskole, beliggenhed, kommune, kort, vejbeskrivelse, k�rselsvejledning, k�rsel, rutebeskrivelse, hvor ligger skolen, placering, k�rselsvejvisning, k�rselshenvisningormation, transport, indfaldsveje, stationer, station';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $tpl = $this->template->create('Kontakt/beliggenhed');
        return $tpl->render($this);
    }
}
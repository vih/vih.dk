<?php
class VIH_Controller_Om_Accessibility extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'Tilg�ngelighed p� websitet';
        $meta['description'] = 'Erkl�ring om tilg�ngelighed p� webstedet.';
        $meta['keywords'] = 'tilg�ngelighedserkl�ring, tilg�ngelighed, w3c, w3, html-standarder, html, standarder, lix, lixtal, lix-tal';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $tpl = $this->template->create('Om/accessibility');
        return $tpl->render($this);
    }
}
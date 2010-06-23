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
        $title = 'Tilgï¿½ngelighed pï¿½ websitet';
        $meta['description'] = 'Erklï¿½ring om tilgï¿½ngelighed pï¿½ webstedet.';
        $meta['keywords'] = 'tilgï¿½ngelighedserklï¿½ring, tilgï¿½ngelighed, w3c, w3, html-standarder, html, standarder, lix, lixtal, lix-tal';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $tpl = $this->template->create('Om/accessibility');
        return $tpl->render($this);
    }
}
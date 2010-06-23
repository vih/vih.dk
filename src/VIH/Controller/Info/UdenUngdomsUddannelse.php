<?php
class VIH_Controller_Info_UdenUngdomsUddannelse extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function GET()
    {
        $title = 'Indsats for elever uden ungdomsuddannelse';
        $meta['description'] = '';
        $meta['keywords'] = '';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';

        $tpl = $this->template->create('Info/udenungdomsuddannelse');
        return $tpl->render($this);
    }
}
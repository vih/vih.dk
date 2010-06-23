<?php
class VIH_Controller_Info_Vaerdigrundlag extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'VÃ¦rdigrundlag';
        $meta['description'] = '';
        $meta['keywords'] = '';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';

        $tpl = $this->template->create('Info/værdigrundlag');
        return $tpl->render($this);
    }
}
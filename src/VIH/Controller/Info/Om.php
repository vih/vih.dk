<?php
class VIH_Controller_Info_Om extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'Om Vejle Idrætshøjskole';
        $meta['description'] = 'Vejle Idrætshøjskole er en idrætshøjskole. Højskolelivet dækker over mange ting, det er umuligt at beskrive. Vi har alligevel forsøgt: Læs noget om det her.';
        $meta['keywords'] = 'Vejle, Idrætshøjskole, jyske, idrætsskole, højskolekurser, højskolekursus, højskoleliv, weekend, lovtekster, love, statistik, fortolkning';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';
        $this->document->theme = 'organisation';

        $tpl = $this->template->create('Info/om');
        return $tpl->render($this);
    }
}
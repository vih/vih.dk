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
        $title = 'Om Vejle Idr�tsh�jskole';
        $meta['description'] = 'Vejle Idr�tsh�jskole er en idr�tsh�jskole. H�jskolelivet d�kker over mange ting, det er umuligt at beskrive. Vi har alligevel fors�gt: L�s noget om det her.';
        $meta['keywords'] = 'Vejle, Idr�tsh�jskole, jyske, idr�tsskole, h�jskolekurser, h�jskolekursus, h�jskoleliv, weekend, lovtekster, love, statistik, fortolkning';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';
        $this->document->theme = 'organisation';

        $tpl = $this->template->create('Info/om');
        return $tpl->render($this);
    }
}
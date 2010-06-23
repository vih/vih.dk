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
        $title = 'Om Vejle Idrï¿½tshï¿½jskole';
        $meta['description'] = 'Vejle Idrï¿½tshï¿½jskole er en idrï¿½tshï¿½jskole. Hï¿½jskolelivet dï¿½kker over mange ting, det er umuligt at beskrive. Vi har alligevel forsï¿½gt: Lï¿½s noget om det her.';
        $meta['keywords'] = 'Vejle, Idrï¿½tshï¿½jskole, jyske, idrï¿½tsskole, hï¿½jskolekurser, hï¿½jskolekursus, hï¿½jskoleliv, weekend, lovtekster, love, statistik, fortolkning';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';
        $this->document->theme = 'organisation';

        $tpl = $this->template->create('Info/om');
        return $tpl->render($this);
    }
}
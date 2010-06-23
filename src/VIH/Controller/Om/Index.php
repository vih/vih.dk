<?php
class VIH_Controller_Om_Index extends k_Component
{
    public $map = array('persondata' => 'VIH_Controller_Om_Persondata',
                        'accessibility' => 'VIH_Controller_Om_Accessibility');

    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function map($name)
    {
        return $this->map[$name];
    }

    function GET()
    {
        $title = 'Om hjemmesiden';
        $meta['description'] = 'Oplysninger informationspolitik og informationsstrategi - herunder om aktualitet og opdatering.';
        $meta['keywords'] = 'aktualitet, opdatering, ophavsret, copyright, bedst på nettet, stategi, politik, opdateringspolitik, håndtering, e-mail';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $tpl = $this->template->create('Om/index');
        $content = $tpl->render($this);

        $data = array('content'  => autoop($content));

        $tpl = $this->template->create('wrapper');
        return $tpl->render($this, $data);
    }

    function wrapHtml($content)
    {
        $data = array('content' => $content);
        $tpl = $this->template->create('wrapper');
        return $tpl->render($this, $data);
    }
}
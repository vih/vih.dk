<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Facilitet_Index extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function map($name)
    {
        return 'VIH_Controller_Facilitet_Show';
    }

    function renderHtml()
    {
        $title = 'Faciliteter';
        $meta['description'] = 'Beskrivelse af alle faciliteterne på Vejle Idrætshøjskole.';
        $meta['keywords'] = 'faciliteter';

        $this->document->setTitle($title);
        $this->document->addCrumb($this->name(), $this->url());
        $this->document->meta  = $meta;
        $this->document->theme = 'faciliteter';

        // <h1>Faciliteter - en dejlig legeplads!</h1>

        $data = array('content' => '
            ' . $this->getVideo(),
                      'content_sub' => $this->getSubContent());

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }

    function getContent()
    {
        $tpl = $this->template->create('Facilitet/oversigtsbillede');
        $data = array('faciliteter' => VIH_Model_Facilitet::getList('højskole'));
        return '<p>Klik dig rundt nedenunder for at tage en rundtur på Vejle Idrætshøjskole.</p>
        ' . $tpl->render($this, $data);
    }

    function getSubContent()
    {
        return '<h2>Bestil en rundvisning</h2>
            <p>Du er meget velkommen til at ringe til skolen og aftale et tidspunkt for en rigtig rundvisning. Kontakt Peter Sebastian på 2929 6387.</p>';
    }

    function getVideo()
    {
        $url = $this->url('/gfx/flash/vih-rundvisning.flv');
        $data = array('url' => $url, 'height' => 301, 'width' => 400, 'preview' => $this->url('/gfx/images/rundvisning.jpg'));
        $tpl = $this->template->create('rundvisning-flv');

        $this->document->addScript($this->url('/scripts/swfobject.js'));
        return '<div id="flashwrap">' . $tpl->render($this, $data) . '</div>';
    }
}
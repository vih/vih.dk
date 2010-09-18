<?php
class VIH_Controller_Ansat_Show extends k_Component
{
    protected $template;
    protected $underviser;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function dispatch()
    {
        $this->underviser = new VIH_Model_Ansat($this->name());

        if (!$this->underviser->get('id') OR $this->underviser->get('published') == 0) {
            throw new k_PageNotFound();
        }

        return parent::dispatch();
    }

    function map($name)
    {
        return 'VIH_Controller_Ansat_Kontakt';
    }

    function renderHtml()
    {
        $title = $this->underviser->get('navn');
        $meta['description'] = $this->underviser->get('description');
        $meta['keywords'] = '';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'sidepicture';
        $this->document->body_id = 'underviser';
        $this->document->sidepicture = $this->getSidePicture($this->underviser->get('pic_id'));

        $data = array(
            'content' => '
            '.autoop($this->underviser->get('beskrivelse')).'
            <p class="fn"><strong>'.$this->underviser->get('navn').', '.$this->underviser->get('titel').'</strong> (<a href="'.$this->url('kontakt').'">Kontakt</a>)</p>
        ', 'content_sub' => $this->getSubContent());

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }

    function getSidePicture($pic_id)
    {
        $file = new VIH_FileHandler($pic_id);
        $file->loadInstance('sidepicture');
        return $file->get('file_uri');
    }

    function getSubContent()
    {
        return autoop($this->underviser->getExtraInfo());
    }

    function getFagHTML()
    {
        $fag_html = '';

        $tpl = $this->template->create('Fag/fag');

        if (count($this->underviser->getFag()) > 0) {
            $data = array('fag' => $this->underviser->getFag());
            $fag_html = '<h2>Underviser i</h2>'.$tpl->render($this, $data);
        }
        return $fag_html;
    }
}
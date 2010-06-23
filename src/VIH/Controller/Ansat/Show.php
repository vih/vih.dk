<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Ansat_Show extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function dispatch()
    {
        $underviser = new VIH_Model_Ansat($this->name());

        if (!$underviser->get('id') OR $underviser->get('published') == 0) {
            throw new k_PageNotFound();
        }

        return parent::dispatch();
    }

    function GET()
    {
        $underviser = new VIH_Model_Ansat($this->name());

        $title = $underviser->get('navn');
        $meta['description'] = $underviser->get('description');
        $meta['keywords'] = '';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'sidepicture';
        $this->document->body_id = 'underviser';
        $this->document->sidepicture = $this->getSidePicture($underviser->get('pic_id'));

        $data = array(
            'content' => '
            '.autoop($underviser->get('beskrivelse')).'
            <p class="fn"><strong>'.$underviser->get('navn').', '.$underviser->get('titel').'</strong> (<a href="'.$this->url('kontakt').'">Kontakt</a>)</p>
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
        $underviser = new VIH_Model_Ansat($this->name());

        return autoop($underviser->getExtraInfo());
    }

    function getFagHTML()
    {
        $underviser = new VIH_Model_Ansat($this->name());
        $fag_html = '';

        $tpl = $this->template->create('Fag/fag');

        if (count($underviser->getFag()) > 0) {
            $data = array('fag' => $underviser->getFag());
            $fag_html = '<h2>Underviser i</h2>'.$tpl->render($this, $data);
        }
        return $fag_html;
    }

    function map($name)
    {
        return 'VIH_Controller_Ansat_Kontakt';
    }
}
<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Facilitet_Show extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function GET()
    {
        $id = strip_tags($this->name());
        $facilitet = new VIH_Model_Facilitet($id);

        $file = new VIH_FileHandler($facilitet->get('pic_id'));
        $file->loadInstance('medium');
        $html = $file->getImageHtml();

        $title = $facilitet->get('navn');
        $meta['description'] = $facilitet->get('description');
        $meta['keywords'] = '';

        $this->document->setTitle($title);
        $this->document->meta  = $meta;
        $this->document->theme  = 'faciliteter';

        $data = array('content' => '
            <h1>'.$facilitet->get('navn').'</h1>
            '.$html.'
            <div>'.autoop($facilitet->get('beskrivelse')).'</div>',
                       'content_sub' => $this->getFaciliteterList());
        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }

    function getFaciliteterList()
    {
        $data = array('faciliteter' => VIH_Model_Facilitet::getList('h�jskole'));
        $tpl = $this->template->create('Facilitet/faciliteter');
        return $tpl->render($this, $data);
    }
}
<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Facilitet_Show extends k_Controller
{
    function GET()
    {
        $id = strip_tags($this->name);
        $facilitet = new VIH_Model_Facilitet($id);

        $file = new VIH_FileHandler($facilitet->get('pic_id'));
        $file->loadInstance('medium');
        $html = $file->getImageHtml();

        $title = $facilitet->get('navn');
        $meta['description'] = $facilitet->get('description');
        $meta['keywords'] = '';

        $this->document->title = $title;
        $this->document->meta  = $meta;
        $this->document->theme  = 'faciliteter';

        $data = array('content' => '
            <h1>'.$facilitet->get('navn').'</h1>
            '.$html.'
            <div>'.autoop($facilitet->get('beskrivelse')).'</div>',
                       'content_sub' => $this->getFaciliteterList());
        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);
    }

    function getFaciliteterList()
    {
        $data = array('faciliteter' => VIH_Model_Facilitet::getList('højskole'));
        return $this->render('VIH/View/Facilitet/faciliteter-tpl.php', $data);
    }
}
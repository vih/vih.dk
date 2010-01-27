<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Ansat_Show extends k_Controller
{
    function GET()
    {
        $underviser = new VIH_Model_Ansat($this->name);

        if (!$underviser->get('id') OR $underviser->get('published') == 0) {
            throw new k_http_Response(404);
        }

        $title = $underviser->get('navn');
        $meta['description'] = $underviser->get('description');
        $meta['keywords'] = '';

        $this->document->title = $title;
        $this->document->meta = $meta;
        $this->document->body_class = 'sidepicture';
        $this->document->body_id = 'underviser';
        $this->document->sidepicture = $this->getSidePicture($underviser->get('pic_id'));

        $data = array(
            'content' => '
            '.autoop($underviser->get('beskrivelse')).'
            <p class="fn"><strong>'.$underviser->get('navn').', '.$underviser->get('titel').'</strong> (<a href="'.$this->url('kontakt').'">Kontakt</a>)</p>
        ', 'content_sub' => $this->getSubContent());

        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);
    }

    function getSidePicture($pic_id)
    {
        $file = new VIH_FileHandler($pic_id);
        $file->loadInstance('sidepicture');
        return $file->get('file_uri');
    }

    function getSubContent()
    {
        $underviser = new VIH_Model_Ansat($this->name);

        return autoop($underviser->getExtraInfo());
    }

    function getFagHTML()
    {
        $underviser = new VIH_Model_Ansat($this->name);
        $fag_html = '';

        if (count($underviser->getFag()) > 0) {
            $data = array('fag' => $underviser->getFag());
            $fag_html = '<h2>Underviser i</h2>'.$this->render('VIH/View/Fag/fag-tpl.php', $data);
        }
        return $fag_html;
    }

    function forward($name)
    {
        $next = new VIH_Controller_Ansat_Kontakt($this, $name);
        return $next->handleRequest();
    }
}
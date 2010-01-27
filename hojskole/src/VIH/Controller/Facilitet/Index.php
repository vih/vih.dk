<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Facilitet_Index extends k_Controller
{
    function GET()
    {
        $title = 'Faciliteter';
        $meta['description'] = 'Beskrivelse af alle faciliteterne på Vejle Idrætshøjskole.';
        $meta['keywords'] = 'faciliteter';

        $this->document->title = $title;
        $this->document->meta  = $meta;
        $this->document->theme = 'faciliteter';

        // <h1>Faciliteter - en dejlig legeplads!</h1>

        $data = array('content' => '
            ' . $this->getVideo(),
                      'content_sub' => $this->getSubContent());

        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);
    }

    function getContent()
    {
        $data = array('faciliteter' => VIH_Model_Facilitet::getList('højskole'));
        return '<p>Klik dig rundt nedenunder for at tage en rundtur på Vejle Idrætshøjskole.</p>
        ' . $this->render('VIH/View/Facilitet/oversigtsbillede-tpl.php', $data);
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


        $this->document->scripts[] = $this->url('/scripts/swfobject.js');
        return '<div id="flashwrap">' . $this->render('VIH/View/rundvisning-flv.tpl.php', $data) . '</div>';
    }

    function handleRequest()
    {
        $this->document->trail[$this->name] = $this->url();
        return parent::handleRequest();
    }

    function forward($name)
    {
        $next = new VIH_Controller_Facilitet_Show($this, $name);
        return $next->handleRequest();
    }

}
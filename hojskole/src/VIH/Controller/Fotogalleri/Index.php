<?php
class VIH_Controller_Fotogalleri_Index extends k_Controller
{
    function GET()
    {
        $db = $this->registry->get('database:mdb2');

        $result = $db->query('SELECT id FROM fotogalleri WHERE active = 1 ORDER BY date_created DESC LIMIT 1');
        if (PEAR::isError($result)) {
            throw new Exception($result->getUserInfo());
        }

        if (!$row = $result->fetchRow()) {
            // @todo Make sure that there is some kind of standard and log it
            $data = array('content' => '<h1>Fotogalleri</h1><p>Kunne ikke finde nogen gallerier.</p>', 'content_sub' => $this->getSubContent());
        }

        // HACK start
        $kernel = $this->registry->get('intraface:kernel');
        $kernel->session_id = $this->SESSION->getSessionId();
        // HACK end
        $appender = new VIH_AppendFile($kernel, 'fotogalleri', $row['id']);
        $appender->getDBQuery()->setFilter('order_by', 'name');

        $photos = $appender->getList();
        $photo = array();

        for ($i = 0, $max = count($photos); $i < $max; $i++) {
            $filehandler = new Ilib_Filehandler($kernel, $photos[$i]['file_handler_id']);
            $filehandler->createInstance('filgallerithumb');
            $photos[$i]['instance'] = $filehandler->instance->get();
            $photos[$i]['show_url'] = $this->url($photos[$i]['id']);
        }

        if (empty($photos)) {
            $data = array('content' => '<h1>Fotogalleri</h1><p>Galleriet et tomt</p>', 'content_sub' => $this->getSubContent());
        } else {
            $list = array('photos' => $photos);
            $data = array('content' => $this->render('VIH/View/Fotogalleri/list-tpl.php', $list), 'content_sub' => $this->getSubContent());
        }

        $this->document->title = 'Årets højdepunkter';
        $this->document->theme = 'photogallery';

        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);
    }

    function getSubContent()
    {
        return '<h2>Årets højdepunkter</h2>' . $this->getNews();
    }

    function getNews()
    {
        $data = array('nyheder' => VIH_News::getList('', 3, 'Høj'));
        return $this->render('VIH/View/News/sidebar-featured.tpl.php', $data) . '<p><a href="'.$this->url('/nyheder').'">Flere nyheder</a></p>';
    }

    function forward($name)
    {
        $next = new VIH_Controller_Fotogalleri_Show($this, $name);
        return $next->handleRequest();
    }

    function handleRequest()
    {
        $this->document->trail[$this->name] = $this->url();
        return parent::handleRequest();
    }
}
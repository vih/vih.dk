<?php
class VIH_Controller_Fotogalleri_Index extends k_Component
{
    protected $mdb2;
    protected $kernel;
    protected $template;

    function __construct(MDB2_Driver_Common $db, VIH_Intraface_Kernel $kernel, k_TemplateFactory $template)
    {
        $this->kernel = $kernel;
        $this->mdb2 = $db;
        $this->template = $template;
    }

    function renderHtml()
    {
        $result = $this->mdb2->query('SELECT id FROM fotogalleri WHERE active = 1 ORDER BY date_created DESC LIMIT 1');
        if (PEAR::isError($result)) {
            throw new Exception($result->getUserInfo());
        }

        if (!$row = $result->fetchRow()) {
            // @todo Make sure that there is some kind of standard and log it
            $data = array('content' => '<h1>Fotogalleri</h1><p>Kunne ikke finde nogen gallerier.</p>', 'content_sub' => $this->getSubContent());
        }

        // HACK start
        $this->kernel->session_id = uniqid();
        // HACK end
        $appender = new VIH_AppendFile($this->kernel, 'fotogalleri', $row['id']);
        $appender->getDBQuery()->setFilter('order_by', 'name');

        $photos = $appender->getList();
        $photo = array();

        for ($i = 0, $max = count($photos); $i < $max; $i++) {
            $filehandler = new Ilib_Filehandler($this->kernel, $photos[$i]['file_handler_id']);
            $filehandler->createInstance('filgallerithumb');
            $photos[$i]['instance'] = $filehandler->instance->get();
            $photos[$i]['show_url'] = $this->url($photos[$i]['id']);
        }

        $tpl = $this->template->create('Fotogalleri/list');

        if (empty($photos)) {
            $data = array('content' => '<h1>Fotogalleri</h1><p>Galleriet et tomt</p>', 'content_sub' => $this->getSubContent());
        } else {
            $list = array('photos' => $photos);
            $data = array('content' => $tpl->render($this, $list), 'content_sub' => $this->getSubContent());
        }

        $this->document->setTitle('Årets højdepunkter');
        $this->document->theme = 'photogallery';

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }

    function getSubContent()
    {
        return '<h2>Årets højdepunkter</h2>' . $this->getNews();
    }

    function getNews()
    {
        $data = array('nyheder' => VIH_News::getList('', 3, 'Høj'));
        $tpl = $this->template->create('News/sidebar-featured');
        return $tpl->render($this, $data) . '<p><a href="'.$this->url('/nyheder').'">Flere nyheder</a></p>';
    }

    function map($name)
    {
        return 'VIH_Controller_Fotogalleri_Show';
    }
}
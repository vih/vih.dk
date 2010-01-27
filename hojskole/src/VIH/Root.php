<?php
class VIH_Root extends k_Dispatcher
{
    public $map = array('stylesheet'   => 'VIH_Controller_Stylesheet_Index',
                        'index'        => 'VIH_Controller_Index',
                        'faciliteter'  => 'VIH_Controller_Facilitet_Index',
                        'langekurser'  => 'VIH_Controller_LangtKursus_Index',
                        'kortekurser'  => 'VIH_Controller_KortKursus_Index',
                        'nyheder'      => 'VIH_Controller_News_Index',
                        'fotogalleri'  => 'VIH_Controller_Fotogalleri_Index',
                        'underviser'   => 'VIH_Controller_Ansat_Index',
                        'fag'          => 'VIH_Controller_Fag_Index',
                        'nyhedsbrev'   => 'VIH_Controller_Newsletter_Index',
                        'sitemap'      => 'VIH_Controller_Sitemap_Index',
                        'bestilling'   => 'VIH_Controller_MaterialeBestilling_Index',
                        'info'         => 'VIH_Controller_Info_Index',
                        'kontakt'      => 'VIH_Controller_Kontakt_Index',
                        'om'           => 'VIH_Controller_Om_Index',
                        'rss'          => 'VIH_Controller_RSS_Index',
                        'fotogalleri'  => 'VIH_Controller_Fotogalleri_Index',
                        'file'         => 'Ilib_Filehandler_Controller_Viewer');
    private $dbquery;

    function __construct()
    {
        parent::__construct();
        $GLOBALS['_global_function_callback_url'] = array($this, 'url');
        $GLOBALS['_global_function_callback_e'] = array($this, 'outputString');
        $this->document->template = 'VIH/View/main.tpl.php';
        $this->document->feeds = array();
        $this->document->trail = array();
        $this->document->meta = array('description' => '', 'keywords' => '');
        $this->document->title = 'Vejle Idrætshøjskole';
        $this->document->body_id = 'vih';
        $this->document->body_class = '';
        $this->document->theme = '';
        $this->document->protocol = substr($this->url(), 0, 5);
    }

    function execute()
    {
        return $this->forward('index');
    }

    protected function forward($name)
    {
        $this->document->trail['forside'] = $this->url();
        $response = parent::forward($name);
        $model = array(
            'content' => $response,
            'navigation' => array(
                array('url' => $this->url('/faciliteter'), 'navigation_name' => 'Rundvisning'),
                array('url' => $this->url('/fotogalleri'), 'navigation_name' => 'Højdepunkter'),
                array('url' => $this->url('/nyheder'), 'navigation_name' => 'Nyheder'),
                array('url' => $this->url('/fag'), 'navigation_name' => 'Linjer og specialer'),
                array('url' => $this->url('/langekurser'), 'navigation_name' => 'Lange kurser'),
                array('url' => $this->url('/langekurser/rejser'), 'navigation_name' => 'Rejser'),
                array('url' => $this->url('/kortekurser'), 'navigation_name' => 'Korte kurser'),
                array('url' => $this->url('/underviser'), 'navigation_name' => 'Lærerkræfter'),
                array('url' => $this->url('/info'), 'navigation_name' => 'Info og filosofi'),
                array('url' => $this->url('/bestilling'), 'navigation_name' => 'Bestilling')
            ),
            'url' => $this->url('/'),
            'site_info' => '<a href="'.$this->url('/kontakt') .'">Vejle Idrætshøjskole</a> Ørnebjervej 28 7100 Vejle Tlf. 7582 0811 ' . email('kontor@vih.dk'),
            'name' => 'Vejle Idrætshøjskole',
            'navigation_section' => array(
                array('url' => 'http://vih.dk/kursuscenter/', 'navigation_name' => 'Kursuscenter'),
                array('url' => 'http://vih.dk/elevforeningen/', 'navigation_name' => 'Elevforeningen'),
                array('url' => 'http://www.vies.dk/', 'navigation_name' => 'Efterskole')
            )
        );
        return $this->render('VIH/View/body.tpl.php', $model);
    }

    function getSidePicture()
    {
        if (!empty($this->document->sidepicture)) {
            return ' style="background-image: url('.$this->document->sidepicture.')"';
        }

        if (!strstr($this->document->body_class, 'sidepicture')) {
            return '';
        }

        if (strstr($this->document->body_class, 'widepicture')) {
            $size = 'widepicture';
            $standard = url('/gfx/images/hojskole.jpg');
        } elseif (strstr($this->document->body_class, 'sidepicture')) {
            $size = 'sidepicture';
            $standard = url('/gfx/images2/sidepic3.jpg');
        } else {
            return ;
        }

        $kernel = $this->registry->get('intraface:kernel');
        $module = $kernel->module('filemanager');
        $translation = $kernel->getTranslation('filemanager');
        $filemanager = new Ilib_Filehandler_Manager($kernel);

        if (!empty($this->document->theme)) {
            $keywords = array('worthshowing', $this->document->theme);
        } else {
            $keywords = array('worthshowing');
        }

        try {
            $img = new Ilib_Filehandler_ImageRandomizer($filemanager, $keywords);
            $file = $img->getRandomImage();
            $instance = $file->getInstance($size);
            $editor_img_uri = $this->url('/file.php') . $instance->get('file_uri_parameters');
            $editor_img_height = $instance->get('height');
            $editor_img_width = $instance->get('width');
            return ' style="background-image: url('.$editor_img_uri.')"';
        } catch (Exception $e) {
            return ' style="background-image: url('.$standard.')"';
        }
    }

    function getHighlight()
    {
        $keywords = array('topbar');
        if(!is_array($keywords)) {
            throw new Exception('parameter should be an array with keywords');
        }

        $keyword_ids = array();
        foreach($keywords as $keyword) {
            $keyword_object = new Ilib_Keyword(new VIH_News);
            // @todo: This is not really good, but the only way to identify keyword on name!
            $keyword_ids[] = $keyword_object->save(array('keyword' => $keyword));
        }

        $this->getDBQuery()->setKeyword((array)$keyword_ids);

        $db = $this->getDBQuery()->getRecordset("nyhed.id", "", false);

        $news = array();

        while($db->nextRecord()) {
            $news[] = new VIH_News($db->f('id'));
        }

        if (empty($news)) {
            return '<p>Spørgsmål til højskoleophold eller rundvisning<span>Kontakt Peter Sebastian på 2929 6387 eller ps@vih.dk.</span></p>';

        } else {
            return '<p>'.$news[0]->get('title').'<span>'.$news[0]->get('tekst').'</span></p>';
        }
    }

    function getSubContent()
    {
        return '<h2>Sidelinjen</h2><p>This will be some side content later on</p>';
    }


    function getDBQuery()
    {
        if ($this->dbquery) {
            return $this->dbquery;
        }
        $dbquery = new Ilib_DBQuery("nyhed", "nyhed.active = 1");
        return ($this->dbquery = $dbquery);
    }

}
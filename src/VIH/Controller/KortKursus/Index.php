<?php
if (!defined('KORTEKURSER_STATUS_FÅ_LEDIGE_PLADSER')) {
    define('KORTEKURSER_STATUS_FÅ_LEDIGE_PLADSER', 10);
}

if (!defined('KORTEKURSER_STATUS_UDSOLGT')) {
    define('KORTEKURSER_STATUS_UDSOLGT', 0);
}

class VIH_Controller_KortKursus_Index extends k_Component
{
    private $main;
    private $content;
    private $table;
    private $news_tpl;
    protected $kernel;
    protected $template;

    function __construct(k_TemplateFactory $template, VIH_Intraface_Kernel $kernel, DB_Sql $db_sql)
    {
        $this->template = $template;
        $this->kernel = $kernel;
        $this->db_sql = $db_sql;
    }

    function map($name)
    {
        if ($name == 'golf') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'kajak') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'camp') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'cykel') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'familiekursus') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'sommerhøjskole') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'login') {
            return 'VIH_Controller_KortKursus_Login_Index';
        } elseif ($name == 'praktiskeoplysninger') {
            return 'VIH_Controller_KortKursus_Praktiskeoplysninger';
        } else {
            return 'VIH_Controller_KortKursus_Show';
        }
    }

    function renderHtml()
    {
        $this->document->theme   = 'kortekurser';
        $this->document->body_class = 'widepicture';

        $kurser = $this->getGateway()->getList('open'); // array with the courses

        $title = 'Korte kurser og sommerkurser på højskole - højskolekurser';
        $meta['description'] = 'Korte kurser og sommerkurser på Vejle Idrætshøjskole. Brug din ferie på højskole. Vi har masser af højskolekurser at vælge mellem.';
        $meta['keywords'] = 'højskole, idrætshøjskole, sommerkurser, sommerkursus, højskolekurser, korte kurser, sommerhøjskole';
        $content_data = array(
            'headline' => 'Korte kurser',
            'text' => 'Vi arrangerer hele året korte højskolekurser. Vi har voksenkurser, familiekurser og kurser for <a href="'.$this->url('/kortekurser/golf/').'">golfentusiaster</a>. Du sparker til livet gennem legen og fordybelsen, diskussionerne og festlighederne. Hvis du har spørgsmål om kurserne, er du meget velkommen til at ringe til skolen eller kursuslederne for de enkelte kurser.');
        $table_data = array('summary' => 'Oversigt over de aktuelle korte kurser på Vejle Idrætshøjskole - højskolekurser',
            'caption' => 'Oversigt over aktuelle korte kurser',
            'kurser' => $this->getGateway()->getList());
        $news_data = array(
            'nyheder' => VIH_News::getList(1));

        $this->document->setTitle($title);
        $this->document->meta    = $meta;
        $this->document->feeds[] = array('title' => 'Korte kurser',
                                         'link' => $this->url('/rss/kortekurser'));
        $this->document->widepicture = $this->getWidePictureUrl($this->document->theme);
        $table = $this->getTable($table_data);

        $data = array_merge(array('table' => $table), $content_data);

        $tpl = $this->template->create('KortKursus/index');
        $content = array('content' => $tpl->render($this, $data), 'content_sub' => $this->getSubContent());

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $content);
    }

    function renderXml()
    {
        $kurser = $this->getGateway()->getList('open');
        $i = 0;
        $items = array();
        foreach ($kurser AS $kursus):
            $items[$i]['title']       = $kursus->get('kursusnavn');
            $items[$i]['description'] = $kursus->get('description');
            $items[$i]['pubDate']     = $kursus->get('date_updated_rfc822');
            $items[$i]['author']      = htmlspecialchars('Vejle Idrætshøjskole <kontor@vih.dk>');
            $items[$i]['link']        = 'http://vih.dk/kortekurser/' . $kursus->get('id') . '/';
            $i++;
        endforeach;

        $data = array(
            'title'       => 'Korte kurser på Vejle Idrætshøjskole',
            'link'        => 'http://vih.dk/',
            'language'    => 'da',
            'description' => 'Kursusoversigten over korte kurser på Vejle Idrætshøjskole',
            'docs'        => 'http://vih.dk/rss/',
            'items'       => $items
        );
        $tpl = $this->template->create('rss20');
        return $tpl->render($this, $data);
    }

    function getGateway()
    {
        return new VIH_Model_KortKursusGateway($this->db_sql);
    }

    function getTable($data)
    {
        $tpl = $this->template->create('KortKursus/kurser');
        return $tpl->render($this, $data);
    }

    function getSubContent()
    {
        $tpl = $this->template->create('spot');

        $data = array('headline' => 'Brochure',
                      'text' => 'Bestil en brochure fra vores <a href="'.$this->url('/bestilling/').'">bestillingsside</a>.');
        $content = $tpl->render($this, $data);

        $data = array('headline' => 'Praktiske oplysninger',
                      'text' => '<a href="'.$this->url('./praktiskeoplysninger').'">Læs om de praktiske oplysninger</a>.');
        $content .= $tpl->render($this, $data);

        return $content;
    }

    function getWidePictureUrl($identifier)
    {
        $filemanager = new Ilib_Filehandler_Manager($this->kernel);

        try {
            $img = new Ilib_Filehandler_ImageRandomizer($filemanager, array($identifier));
            $file = $img->getRandomImage();
        } catch (Exception $e) {
            return $this->url('/gfx/images/højskole.jpg');
        }

        $instance = $file->createInstance('widepicture');
        $editor_img_uri = $instance->get('file_uri');
        $editor_img_height = $instance->get('height');
        $editor_img_width = $instance->get('width');

        return $this->url('/file.php') . $instance->get('file_uri_parameters');
    }
}
<?php
/**
 * Controller for the intranet
 */
if (!defined('KORTEKURSER_STANDARDPRISER_AFBESTILLINGSFORSIKRING')) {
    define('KORTEKURSER_STANDARDPRISER_AFBESTILLINGSFORSIKRING', 200);
}

if (!defined('KORTEKURSER_STATUS_FAA_LEDIGE_PLADSER')) {
    define('KORTEKURSER_STATUS_FAA_LEDIGE_PLADSER', 10);
}

if (!defined('KORTEKURSER_STATUS_UDSOLGT')) {
    define('KORTEKURSER_STATUS_UDSOLGT', 0);
}

class VIH_Controller_KortKursus_Group extends k_Component
{
    private $main;
    private $content;
    private $table;
    private $news_tpl;
    protected $kernel;
    protected $template;

    function __construct(k_TemplateFactory $template, VIH_Intraface_Kernel $kernel)
    {
        $this->template = $template;
        $this->kernel = $kernel;
    }

    function getTable($data)
    {
        $tpl = $this->template->create('KortKursus/kurser');
        return $tpl->render($this, $data);
    }

    function renderHtml()
    {
        return $this->getContent($this->name());
    }

    function getContent($name = '')
    {
        $this->document->theme   = 'kortekurser';
        $this->document->body_class = 'widepicture';

        $kurser = VIH_Model_KortKursus::getList('open', $name); // array with the courses
        switch ($name) {
            case 'golf':
                $title = 'H�jskole og golf - tag p� golfh�jskole p� Vejle Idr�tsh�jskole';
                $meta['description'] = 'Golfkurser: Golfkursus p� Vejle Idr�tsh�jskole krydrer din passion for golf med debat og foredrag p� h�jskole. Golfh�jskole henvender sig til spillere p� flere niveauer: lige fra begynderen til den mere �vede.';
                $meta['keywords'] = 'golf, h�jskole, h�jskolegolf, golfh�jskole, idr�tsh�jskole, golfkursus, kursus, golfkurser';
                $table_data = array('summary' => 'Golfkurser: Oversigt over de aktuelle golfkurser p� Vejle Idr�tsh�jskole. Kig her hvis du vil p� golfkursus.',
                                    'caption' => 'H�jskole og golf - tag et kursus i golf',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'H�jskole og golf - golfh�jskole',
                                      'text' => 'Vi forst�r din passion for golf - og din lyst til at tage p� golfh�jskole. Det er et dejligt spil, og hvad kan v�re bedre end at have en uge p� h�jskole, hvor du har tid og rum til at �ve dig, s� banen i par kommer endnu t�ttere p�. Kurserne henvender sig til spillere p� flere niveauer: lige fra begynderen til den mere �vede. Du kan stille dine sp�rgsm�l til kursuslederne af det golfkursus, du er interesseret i.');
                $news_data = array('nyheder' => VIH_News::getList(1));
                $this->document->theme = 'golf';
                break;
            case 'sommerhojskole':
                $title = 'Sommerh�jskole og sommerkurser - tag p� h�jskole til sommer';
                $meta['description'] = 'Sommerh�jskole og sommerkurser: Tag p� sommerkursus p� h�jskole i l�bet af sommeren. Vi har b�de kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerh�jskole, kurser, sommerkursus, sommerkurser, sommer, h�jskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser p� Vejle Idr�tsh�jskole - h�jskole til sommer, sommerh�jskole',
                                    'caption' => 'Sommerh�jskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Sommerh�jskole p� Vejle Idr�tsh�jskole',
                                     'text' => 'Tag p� h�jskole til sommer og f� en stor oplevelse. At tage p� sommerh�jskole er giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart p�, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges p� h�jskole - og vi har en masse sommerkurser at v�lge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(1));
                $this->document->theme = 'familiekursus';
                break;
            case 'camp':
                $title = 'Idr�tsCamp - tag p� h�jskole til sommer';
                $meta['description'] = 'Sommerh�jskole og sommerkurser: Tag p� Idr�tsCamp p� h�jskole i l�bet af sommeren. Vi har b�de kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerh�jskole, kurser, sommerkursus, sommerkurser, sommer, h�jskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser p� Vejle Idr�tsh�jskole - h�jskole til sommer, sommerh�jskole, idr�tscamp',
                                    'caption' => 'Sommerh�jskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Idr�tsCamp p� Vejle Idr�tsh�jskole',
                                     'text' => 'Tag p� h�jskole til sommer og f� en stor oplevelse. At tage p� sommerh�jskole er giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart p�, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges p� h�jskole - og vi har en masse sommerkurser at v�lge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(7));
                $this->document->theme = 'camp';
                break;
            case 'familiekursus':
                $title = 'Familiekursus - tag p� h�jskole til sommer';
                $meta['description'] = 'Sommerh�jskole og sommerkurser: Tag p� Idr�tsCamp p� h�jskole i l�bet af sommeren. Vi har b�de kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerh�jskole, kurser, sommerkursus, sommerkurser, sommer, h�jskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser p� Vejle Idr�tsh�jskole - h�jskole til sommer, sommerh�jskole, idr�tscamp',
                                    'caption' => 'Sommerh�jskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Familiekursus p� Vejle Idr�tsh�jskole',
                                     'text' => 'Tag p� h�jskole til sommer og f� en stor oplevelse. At tage p� sommerh�jskole er giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart p�, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges p� h�jskole - og vi har en masse sommerkurser at v�lge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(7));
                $this->document->theme = 'camp';
                break;
             case 'cykel':
                $title = 'Cykel & H�jskole - tag p� h�jskole til sommer';
                $meta['description'] = 'Sommerh�jskole og sommerkurser: Tag p� Idr�tsCamp p� h�jskole i l�bet af sommeren. Vi har b�de kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerh�jskole, kurser, sommerkursus, sommerkurser, sommer, h�jskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser p� Vejle Idr�tsh�jskole - h�jskole til sommer, sommerh�jskole, idr�tscamp',
                                    'caption' => 'Sommerh�jskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Cykel & H�jskole p� Vejle Idr�tsh�jskole',
                                     'text' => 'Tag p� h�jskole til sommer og f� en stor oplevelse. At tage p� sommerh�jskole er giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart p�, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges p� h�jskole - og vi har en masse sommerkurser at v�lge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(8));
                $this->document->theme = 'cykel';
                break;
            default:
                $title = 'Korte kurser og sommerkurser p� h�jskole - h�jskolekurser';
                $meta['description'] = 'Korte kurser og sommerkurser p� Vejle Idr�tsh�jskole. Brug din ferie p� h�jskole. Vi har masser af h�jskolekurser at v�lge mellem.';
                $meta['keywords'] = 'h�jskole, idr�tsh�jskole, sommerkurser, sommerkursus, h�jskolekurser, korte kurser, sommerh�jskole';
                $content_data = array('headline' => 'Korte kurser',
                                      'text' => 'Vi arrangerer hele �ret korte h�jskolekurser. Vi har voksenkurser, familiekurser og kurser for <a href="'.$this->url('/kortekurser/golf/').'">golfentusiaster</a>. Du sparker til livet gennem legen og fordybelsen, diskussionerne og festlighederne. Hvis du har sp�rgsm�l om kurserne, er du meget velkommen til at ringe til skolen eller kursuslederne for de enkelte kurser.');
                $table_data = array('summary' => 'Oversigt over de aktuelle korte kurser p� Vejle Idr�tsh�jskole - h�jskolekurser',
                                    'caption' => 'Oversigt over aktuelle korte kurser',
                                    'kurser' => VIH_Model_KortKursus::getList());
                $news_data = array('nyheder' => VIH_News::getList(1));

                break;
        }

        $this->document->setTitle($title);
        $this->document->meta    = $meta;
        $this->document->feeds[] = array('title' => 'Korte kurser',
                                         'link' => $this->url('/rss/kortekurser'));
        $this->document->widepicture = $this->getWidePictureUrl($this->document->theme);
        $table = $this->getTable($table_data);

        $data = array_merge(array('table' => $table), $content_data);

        $tpl = $this->template->create('KortKursus/group');
        $content = array('content' => $tpl->render($this, $data), 'content_sub' => $this->getSubContent());

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $content);

    }

    function getSubContent()
    {
        $tpl = $this->template->create('spot');

        $data = array('headline' => 'Brochure',
                      'text' => 'Bestil en brochure fra vores <a href="'.$this->url('/bestilling/').'">bestillingsside</a>.');
        $content = $tpl->render($this, $data);

        $data = array('headline' => 'Praktiske oplysninger',
                      'text' => '<a href="'.$this->url('./praktiskeoplysninger').'">L�s om de praktiske oplysninger</a>.');
        $content .= $tpl->render($this, $data);

        return $content;
    }

    function map($name)
    {
        /*
        if ($name == 'golf') {
            return $this->getContent($name);
        } elseif ($name == 'camp') {
            return $this->getContent($name);
        } elseif ($name == 'cykel') {
            return $this->getContent($name);
        } elseif ($name == 'familiekursus') {
            return $this->getContent($name);
        } elseif ($name == 'sommerhojskole') {
            return $this->getContent($name);
        */
        if ($name == 'login') {
            return 'VIH_Controller_KortKursus_Login_Index';
        } elseif ($name == 'praktiskeoplysninger') {
            return 'VIH_Controller_KortKursus_Praktiskeoplysninger';
        } else {
            return 'VIH_Controller_KortKursus_Show';
        }
    }

    function getWidePictureUrl($identifier)
    {
        $filemanager = new Ilib_Filehandler_Manager($this->kernel);

        try {
            $img = new Ilib_Filehandler_ImageRandomizer($filemanager, array($identifier));
            $file = $img->getRandomImage();
        } catch (Exception $e) {
            return $this->url('/gfx/images/hojskole.jpg');
        }

        $instance = $file->createInstance('widepicture');
        $editor_img_uri = $instance->get('file_uri');
        $editor_img_height = $instance->get('height');
        $editor_img_width = $instance->get('width');

        return $this->url('/file.php') . $instance->get('file_uri_parameters');
    }

    function renderXml()
    {
        $kurser = VIH_Model_KortKursus::getList('open');
        $i = 0;
        $items = array();
        foreach ($kurser AS $kursus):
            $items[$i]['title']       = $kursus->get('kursusnavn');
            $items[$i]['description'] = $kursus->get('description');
            $items[$i]['pubDate']     = $kursus->get('date_updated_rfc822');
            $items[$i]['author']      = htmlspecialchars('Vejle Idr�tsh�jskole <kontor@vih.dk>');
            $items[$i]['link']        = 'http://vih.dk/kortekurser/' . $kursus->get('id') . '/';
            $i++;
        endforeach;

        $data = array(
            'title'       => 'Korte kurser p� Vejle Idr�tsh�jskole',
            'link'        => 'http://vih.dk/',
            'language'    => 'da',
            'description' => 'Kursusoversigten over korte kurser p� Vejle Idr�tsh�jskole',
            'docs'        => 'http://vih.dk/rss/',
            'items'       => $items
        );
        $tpl = $this->template->create('rss20');
        return $tpl->render($this, $data);
    }
}
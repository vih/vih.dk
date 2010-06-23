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

class VIH_Controller_KortKursus_Index extends k_Component
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
        return $this->getContent();
    }

    function getContent($name = '')
    {
        $this->document->theme   = 'kortekurser';
        $this->document->body_class = 'widepicture';

        $kurser = VIH_Model_KortKursus::getList('open', $name); // array with the courses
        switch ($name) {
            case 'golf':
                $title = 'Hï¿½jskole og golf - tag pï¿½ golfhï¿½jskole pï¿½ Vejle Idrï¿½tshï¿½jskole';
                $meta['description'] = 'Golfkurser: Golfkursus pï¿½ Vejle Idrï¿½tshï¿½jskole krydrer din passion for golf med debat og foredrag pï¿½ hï¿½jskole. Golfhï¿½jskole henvender sig til spillere pï¿½ flere niveauer: lige fra begynderen til den mere ï¿½vede.';
                $meta['keywords'] = 'golf, hï¿½jskole, hï¿½jskolegolf, golfhï¿½jskole, idrï¿½tshï¿½jskole, golfkursus, kursus, golfkurser';
                $table_data = array('summary' => 'Golfkurser: Oversigt over de aktuelle golfkurser pï¿½ Vejle Idrï¿½tshï¿½jskole. Kig her hvis du vil pï¿½ golfkursus.',
                                    'caption' => 'Hï¿½jskole og golf - tag et kursus i golf',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Hï¿½jskole og golf - golfhï¿½jskole',
                                      'text' => 'Vi forstï¿½r din passion for golf - og din lyst til at tage pï¿½ golfhï¿½jskole. Det er et dejligt spil, og hvad kan vï¿½re bedre end at have en uge pï¿½ hï¿½jskole, hvor du har tid og rum til at ï¿½ve dig, sï¿½ banen i par kommer endnu tï¿½ttere pï¿½. Kurserne henvender sig til spillere pï¿½ flere niveauer: lige fra begynderen til den mere ï¿½vede. Du kan stille dine spï¿½rgsmï¿½l til kursuslederne af det golfkursus, du er interesseret i.');
                $news_data = array('nyheder' => VIH_News::getList(1));
                $this->document->theme = 'golf';
                break;
            case 'sommerhojskole':
                $title = 'Sommerhï¿½jskole og sommerkurser - tag pï¿½ hï¿½jskole til sommer';
                $meta['description'] = 'Sommerhï¿½jskole og sommerkurser: Tag pï¿½ sommerkursus pï¿½ hï¿½jskole i lï¿½bet af sommeren. Vi har bï¿½de kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerhï¿½jskole, kurser, sommerkursus, sommerkurser, sommer, hï¿½jskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser pï¿½ Vejle Idrï¿½tshï¿½jskole - hï¿½jskole til sommer, sommerhï¿½jskole',
                                    'caption' => 'Sommerhï¿½jskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Sommerhï¿½jskole pï¿½ Vejle Idrï¿½tshï¿½jskole',
                                     'text' => 'Tag pï¿½ hï¿½jskole til sommer og fï¿½ en stor oplevelse. At tage pï¿½ sommerhï¿½jskole er giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart pï¿½, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges pï¿½ hï¿½jskole - og vi har en masse sommerkurser at vï¿½lge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(1));
                $this->document->theme = 'familiekursus';
                break;
            case 'camp':
                $title = 'Idrï¿½tsCamp - tag pï¿½ hï¿½jskole til sommer';
                $meta['description'] = 'Sommerhï¿½jskole og sommerkurser: Tag pï¿½ Idrï¿½tsCamp pï¿½ hï¿½jskole i lï¿½bet af sommeren. Vi har bï¿½de kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerhï¿½jskole, kurser, sommerkursus, sommerkurser, sommer, hï¿½jskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser pï¿½ Vejle Idrï¿½tshï¿½jskole - hï¿½jskole til sommer, sommerhï¿½jskole, idrï¿½tscamp',
                                    'caption' => 'Sommerhï¿½jskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Idrï¿½tsCamp pï¿½ Vejle Idrï¿½tshï¿½jskole',
                                     'text' => 'Tag pï¿½ hï¿½jskole til sommer og fï¿½ en stor oplevelse. At tage pï¿½ sommerhï¿½jskole er giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart pï¿½, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges pï¿½ hï¿½jskole - og vi har en masse sommerkurser at vï¿½lge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(7));
                $this->document->theme = 'camp';
                break;
            case 'familiekursus':
                $title = 'Familiekursus - tag pï¿½ hï¿½jskole til sommer';
                $meta['description'] = 'Sommerhï¿½jskole og sommerkurser: Tag pï¿½ Idrï¿½tsCamp pï¿½ hï¿½jskole i lï¿½bet af sommeren. Vi har bï¿½de kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerhï¿½jskole, kurser, sommerkursus, sommerkurser, sommer, hï¿½jskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser pï¿½ Vejle Idrï¿½tshï¿½jskole - hï¿½jskole til sommer, sommerhï¿½jskole, idrï¿½tscamp',
                                    'caption' => 'Sommerhï¿½jskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Familiekursus pï¿½ Vejle Idrï¿½tshï¿½jskole',
                                     'text' => 'Tag pï¿½ hï¿½jskole til sommer og fï¿½ en stor oplevelse. At tage pï¿½ sommerhï¿½jskole er giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart pï¿½, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges pï¿½ hï¿½jskole - og vi har en masse sommerkurser at vï¿½lge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(7));
                $this->document->theme = 'camp';
                break;
             case 'cykel':
                $title = 'Cykel & Hï¿½jskole - tag pï¿½ hï¿½jskole til sommer';
                $meta['description'] = 'Sommerhï¿½jskole og sommerkurser: Tag pï¿½ Idrï¿½tsCamp pï¿½ hï¿½jskole i lï¿½bet af sommeren. Vi har bï¿½de kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerhï¿½jskole, kurser, sommerkursus, sommerkurser, sommer, hï¿½jskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser pï¿½ Vejle Idrï¿½tshï¿½jskole - hï¿½jskole til sommer, sommerhï¿½jskole, idrï¿½tscamp',
                                    'caption' => 'Sommerhï¿½jskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Cykel & Hï¿½jskole pï¿½ Vejle Idrï¿½tshï¿½jskole',
                                     'text' => 'Tag pï¿½ hï¿½jskole til sommer og fï¿½ en stor oplevelse. At tage pï¿½ sommerhï¿½jskole er giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart pï¿½, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges pï¿½ hï¿½jskole - og vi har en masse sommerkurser at vï¿½lge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(8));
                $this->document->theme = 'cykel';
                break;
            default:
                $title = 'Korte kurser og sommerkurser pï¿½ hï¿½jskole - hï¿½jskolekurser';
                $meta['description'] = 'Korte kurser og sommerkurser pï¿½ Vejle Idrï¿½tshï¿½jskole. Brug din ferie pï¿½ hï¿½jskole. Vi har masser af hï¿½jskolekurser at vï¿½lge mellem.';
                $meta['keywords'] = 'hï¿½jskole, idrï¿½tshï¿½jskole, sommerkurser, sommerkursus, hï¿½jskolekurser, korte kurser, sommerhï¿½jskole';
                $content_data = array('headline' => 'Korte kurser',
                                      'text' => 'Vi arrangerer hele ï¿½ret korte hï¿½jskolekurser. Vi har voksenkurser, familiekurser og kurser for <a href="'.$this->url('/kortekurser/golf/').'">golfentusiaster</a>. Du sparker til livet gennem legen og fordybelsen, diskussionerne og festlighederne. Hvis du har spï¿½rgsmï¿½l om kurserne, er du meget velkommen til at ringe til skolen eller kursuslederne for de enkelte kurser.');
                $table_data = array('summary' => 'Oversigt over de aktuelle korte kurser pï¿½ Vejle Idrï¿½tshï¿½jskole - hï¿½jskolekurser',
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

        $tpl = $this->template->create('KortKursus/index');
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
                      'text' => '<a href="'.$this->url('./praktiskeoplysninger').'">Lï¿½s om de praktiske oplysninger</a>.');
        $content .= $tpl->render($this, $data);

        return $content;
    }

    function map($name)
    {
        if ($name == 'golf') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'camp') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'cykel') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'familiekursus') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'sommerhojskole') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'login') {
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
            $items[$i]['author']      = htmlspecialchars('Vejle Idrï¿½tshï¿½jskole <kontor@vih.dk>');
            $items[$i]['link']        = 'http://vih.dk/kortekurser/' . $kursus->get('id') . '/';
            $i++;
        endforeach;

        $data = array(
            'title'       => 'Korte kurser pï¿½ Vejle Idrï¿½tshï¿½jskole',
            'link'        => 'http://vih.dk/',
            'language'    => 'da',
            'description' => 'Kursusoversigten over korte kurser pï¿½ Vejle Idrï¿½tshï¿½jskole',
            'docs'        => 'http://vih.dk/rss/',
            'items'       => $items
        );
        $tpl = $this->template->create('rss20');
        return $tpl->render($this, $data);
    }
}
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

class VIH_Controller_KortKursus_Index extends k_Controller
{
    private $main;
    private $content;
    private $table;
    private $news_tpl;

    function __construct($context, $name)
    {
        parent::__construct($context, $name);
    }

    function getTable($data)
    {
        return $this->render('VIH/View/KortKursus/kurser-tpl.php', $data);
    }

    function GET()
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
                $title = 'Højskole og golf - tag på golfhøjskole på Vejle Idrætshøjskole';
                $meta['description'] = 'Golfkurser: Golfkursus på Vejle Idrætshøjskole krydrer din passion for golf med debat og foredrag på højskole. Golfhøjskole henvender sig til spillere på flere niveauer: lige fra begynderen til den mere øvede.';
                $meta['keywords'] = 'golf, højskole, højskolegolf, golfhøjskole, idrætshøjskole, golfkursus, kursus, golfkurser';
                $table_data = array('summary' => 'Golfkurser: Oversigt over de aktuelle golfkurser på Vejle Idrætshøjskole. Kig her hvis du vil på golfkursus.',
                                    'caption' => 'Højskole og golf - tag et kursus i golf',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Højskole og golf - golfhøjskole',
                                      'text' => 'Vi forstår din passion for golf - og din lyst til at tage på golfhøjskole. Det er et dejligt spil, og hvad kan være bedre end at have en uge på højskole, hvor du har tid og rum til at øve dig, så banen i par kommer endnu tættere på. Kurserne henvender sig til spillere på flere niveauer: lige fra begynderen til den mere øvede. Du kan stille dine spørgsmål til kursuslederne af det golfkursus, du er interesseret i.');
                $news_data = array('nyheder' => VIH_News::getList(1));
                $this->document->theme = 'golf';
                break;
            case 'sommerhojskole':
                $title = 'Sommerhøjskole og sommerkurser - tag på højskole til sommer';
                $meta['description'] = 'Sommerhøjskole og sommerkurser: Tag på sommerkursus på højskole i løbet af sommeren. Vi har både kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerhøjskole, kurser, sommerkursus, sommerkurser, sommer, højskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser på Vejle Idrætshøjskole - højskole til sommer, sommerhøjskole',
                                    'caption' => 'Sommerhøjskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Sommerhøjskole på Vejle Idrætshøjskole',
                                     'text' => 'Tag på højskole til sommer og få en stor oplevelse. At tage på sommerhøjskole er giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart på, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges på højskole - og vi har en masse sommerkurser at vælge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(1));
                $this->document->theme = 'familiekursus';
                break;
            case 'camp':
                $title = 'IdrætsCamp - tag på højskole til sommer';
                $meta['description'] = 'Sommerhøjskole og sommerkurser: Tag på IdrætsCamp på højskole i løbet af sommeren. Vi har både kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerhøjskole, kurser, sommerkursus, sommerkurser, sommer, højskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser på Vejle Idrætshøjskole - højskole til sommer, sommerhøjskole, idrætscamp',
                                    'caption' => 'Sommerhøjskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'IdrætsCamp på Vejle Idrætshøjskole',
                                     'text' => 'Tag på højskole til sommer og få en stor oplevelse. At tage på sommerhøjskole er giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart på, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges på højskole - og vi har en masse sommerkurser at vælge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(7));
                $this->document->theme = 'camp';
                break;
            case 'familiekursus':
                $title = 'Familiekursus - tag på højskole til sommer';
                $meta['description'] = 'Sommerhøjskole og sommerkurser: Tag på IdrætsCamp på højskole i løbet af sommeren. Vi har både kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerhøjskole, kurser, sommerkursus, sommerkurser, sommer, højskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser på Vejle Idrætshøjskole - højskole til sommer, sommerhøjskole, idrætscamp',
                                    'caption' => 'Sommerhøjskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Familiekursus på Vejle Idrætshøjskole',
                                     'text' => 'Tag på højskole til sommer og få en stor oplevelse. At tage på sommerhøjskole er giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart på, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges på højskole - og vi har en masse sommerkurser at vælge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(7));
                $this->document->theme = 'camp';
                break;
             case 'cykel':
                $title = 'Cykel & Højskole - tag på højskole til sommer';
                $meta['description'] = 'Sommerhøjskole og sommerkurser: Tag på IdrætsCamp på højskole i løbet af sommeren. Vi har både kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerhøjskole, kurser, sommerkursus, sommerkurser, sommer, højskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser på Vejle Idrætshøjskole - højskole til sommer, sommerhøjskole, idrætscamp',
                                    'caption' => 'Sommerhøjskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Cykel & Højskole på Vejle Idrætshøjskole',
                                     'text' => 'Tag på højskole til sommer og få en stor oplevelse. At tage på sommerhøjskole er giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart på, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges på højskole - og vi har en masse sommerkurser at vælge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(8));
                $this->document->theme = 'cykel';
                break;
            default:
                $title = 'Korte kurser og sommerkurser på højskole - højskolekurser';
                $meta['description'] = 'Korte kurser og sommerkurser på Vejle Idrætshøjskole. Brug din ferie på højskole. Vi har masser af højskolekurser at vælge mellem.';
                $meta['keywords'] = 'højskole, idrætshøjskole, sommerkurser, sommerkursus, højskolekurser, korte kurser, sommerhøjskole';
                $content_data = array('headline' => 'Korte kurser',
                                      'text' => 'Vi arrangerer hele året korte højskolekurser. Vi har voksenkurser, familiekurser og kurser for <a href="'.$this->url('/kortekurser/golf/').'">golfentusiaster</a>. Du sparker til livet gennem legen og fordybelsen, diskussionerne og festlighederne. Hvis du har spørgsmål om kurserne, er du meget velkommen til at ringe til skolen eller kursuslederne for de enkelte kurser.');
                $table_data = array('summary' => 'Oversigt over de aktuelle korte kurser på Vejle Idrætshøjskole - højskolekurser',
                                    'caption' => 'Oversigt over aktuelle korte kurser',
                                    'kurser' => VIH_Model_KortKursus::getList());
                $news_data = array('nyheder' => VIH_News::getList(1));

                break;
        }

        $this->document->title   = $title;
        $this->document->meta    = $meta;
        $this->document->feeds[] = array('title' => 'Korte kurser',
                                         'link' => $this->url('/rss/kortekurser'));
        $this->document->widepicture = $this->getWidePictureUrl($this->document->theme);
        $table = $this->getTable($table_data);

        $data = array_merge(array('table' => $table), $content_data);

        $content = array('content' => $this->render('VIH/View/KortKursus/index-tpl.php', $data), 'content_sub' => $this->getSubContent());

        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $content);

    }

    function getSubContent()
    {
        $data = array('headline' => 'Brochure',
                      'text' => 'Bestil en brochure fra vores <a href="'.$this->url('/bestilling/').'">bestillingsside</a>.');
        $content = $this->render('VIH/View/spot-tpl.php', $data);

        $data = array('headline' => 'Praktiske oplysninger',
                      'text' => '<a href="'.$this->url('./praktiskeoplysninger').'">Læs om de praktiske oplysninger</a>.');
        $content .= $this->render('VIH/View/spot-tpl.php', $data);

        return $content;
    }

    function forward($name)
    {
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
        } elseif ($name == 'login') {
            $next = new VIH_Controller_KortKursus_Login_Index($this, $name);
            return $next->handleRequest();
        } elseif ($name == 'praktiskeoplysninger') {
            $next = new VIH_Controller_KortKursus_Praktiskeoplysninger($this, $name);
            return $next->handleRequest();
        } else {
            $next = new VIH_Controller_KortKursus_Show($this, $name);
            return $next->handleRequest();
        }
    }

    function handleRequest()
    {
        $this->document->trail[$this->name] = $this->url();
        return parent::handleRequest();
    }

    function getWidePictureUrl($identifier)
    {
        $kernel = $this->registry->get('intraface:kernel');
        $translation = $kernel->getTranslation('filemanager');
        $filemanager = new Ilib_Filehandler_Manager($kernel);

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

}
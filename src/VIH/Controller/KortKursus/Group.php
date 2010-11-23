<?php
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

    function map($name)
    {
        if ($name == 'login') {
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

        $kurser = $this->context->getGateway()->getList('open', $this->name()); // array with the courses
        switch ($name) {
            case 'golf':
                $title = 'Højskole og golf - tag på golfhøjskole på Vejle Idrætshøjskole';
                $meta['description'] = 'Golfkurser: Golfkursus på Vejle Idrætshøjskole krydrer din passion for golf med debat og foredrag på højskole. Golfhøjskole henvender sig til spillere på flere niveauer: lige fra begynderen til den mere øvede.';
                $meta['keywords'] = 'golf, højskole, højskolegolf, golfhøjskole, idrætshøjskole, golfkursus, kursus, golfkurser';
                $table_data = array('summary' => 'Golfkurser: Oversigt over de aktuelle golfkurser på Vejle Idrætshøjskole. Kig her hvis du vil på golfkursus.',
                                    'caption' => 'Højskole og golf - tag et kursus i golf',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Højskole og golf - golfhøjskole',
                                      'text' => 'Vi forstår din passion for golf - og din lyst til at tage på golfhøjskole. Det er et dejligt spil, og hvad kan vïære bedre end at have en uge på højskole, hvor du har tid og rum til at øve dig, så banen i par kommer endnu tættere på. Kurserne henvender sig til spillere på flere niveauer: lige fra begynderen til den mere øvede. Du kan stille dine spørgsmål til kursuslederne af det golfkursus, du er interesseret i.');
                $news_data = array('nyheder' => VIH_News::getList(1));
                $this->document->theme = 'golf';
                break;
            case 'sommerhøjskole':
                $title = 'Sommerhøjskole og sommerkurser - tag på højskole til sommer';
                $meta['description'] = 'Sommerhøjskole og sommerkurser: Tag på sommerkursus på højskole i løbet af sommeren. Vi har både kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerhøjskole, kurser, sommerkursus, sommerkurser, sommer, højskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser på Vejle Idrætshøjskole - højskole til sommer, sommerhøjskole',
                                    'caption' => 'Sommerhøjskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Sommerhøjskole på Vejle Idrætshøjskole',
                                     'text' => 'Tag på højskole til sommer og få en stor oplevelse. At tage på sommerhøjskole giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart på, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges på højskole - og vi har en masse sommerkurser at vælge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(1));
                $this->document->theme = 'familiekursus';
                break;
            case 'camp':
                $title = 'Idrætscamp - tag på højskole til sommer';
                $meta['description'] = 'Sommerhøjskole og sommerkurser: Tag på Idrætscamp på højskole i løbet af sommeren. Vi har både kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerhøjskole, kurser, sommerkursus, sommerkurser, sommer, højskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser på Vejle Idrætshøjskole - højskole til sommer, sommerhøjskole, idrætscamp',
                                    'caption' => 'Sommerhøjskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Idrætscamp på Vejle Idrætshøjskole',
                                     'text' => 'Tag på højskole til sommer og få en stor oplevelse. At tage på sommerhøjskole giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart på, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges på højskole - og vi har en masse sommerkurser at vælge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(7));
                $this->document->theme = 'camp';
                break;
            case 'familiekursus':
                $title = 'Familiekursus - tag på højskole til sommer';
                $meta['description'] = 'Sommerhøjskole og sommerkurser: Tag på Idrætscamp på højskole i løbet af sommeren. Vi har både kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerhøjskole, kurser, sommerkursus, sommerkurser, sommer, højskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser på Vejle Idrætshøjskole - højskole til sommer, sommerhøjskole, idrætscamp',
                                    'caption' => 'Sommerhøjskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Familiekursus på Vejle Idrætshøjskole',
                                     'text' => 'Tag på højskole til sommer og få en stor oplevelse. At tage på sommerhøjskole giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart på, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges på højskole - og vi har en masse sommerkurser at vælge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(7));
                $this->document->theme = 'camp';
                break;
             case 'cykel':
                $title = 'Cykel & Højskole - tag på højskole til sommer';
                $meta['description'] = 'Sommerhøjskole og sommerkurser: Tag på Idrætscamp på højskole i løbet af sommeren. Vi har både kurser til familier eller voksne.';
                $meta['keywords'] = 'sommerhøjskole, kurser, sommerkursus, sommerkurser, sommer, højskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser på Vejle Idrætshøjskole - højskole til sommer, sommerhøjskole, idrætscamp',
                                    'caption' => 'Sommerhøjskole - sommerkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Cykel & Højskole på Vejle Idrætshøjskole',
                                     'text' => 'Tag på højskole til sommer og få en stor oplevelse. At tage på sommerhøjskole giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart på, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges på højskole - og vi har en masse sommerkurser at vælge mellem:');
                $news_data = array('nyheder' => VIH_News::getList(8));
                $this->document->theme = 'cykel';
                break;
            case 'kajak':
                $title = 'Kajak & Højskole - tag på højskole til sommer';
                $meta['description'] = 'Sommerhøjskole og sommerkurser: Tag på Idrætscamp på højskole i løbet af sommeren.';
                $meta['keywords'] = 'sommerhøjskole, kurser, sommerkursus, kajak, sommerkurser, sommer, højskole';
                $table_data = array('summary' => 'Oversigt over aktuelle sommerkurser på Vejle Idrætshøjskole - højskole til sommer, sommerhøjskole, idrætscamp',
                                    'caption' => 'Kajakkurser',
                                    'kurser' => $kurser);
                $content_data = array('headline' => 'Kajak & Højskole på Vejle Idrætshøjskole',
                                     'text' => 'Tag på højskole til sommer og få en stor oplevelse. At tage på sommerhøjskole giver et <em>boost</em> til hverdagen - enten du er en familie med fuld fart på, eller du er voksen og interesserer dig for noget af det samme, som vi interesserer os for. Sommeren skal bruges på højskole - og vi har en masse sommerkurser at vælge mellem:');
                $news_data = array('nyheder' => VIH_News::getList());
                $this->document->theme = 'kajak';
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

    function getTable($data)
    {
        return $this->context->getTable($data);
    }

    function getSubContent()
    {
        return $this->context->getSubContent();
    }

    function getWidePictureUrl($identifier)
    {
        return $this->context->getWidePictureUrl($identifier);
    }
}
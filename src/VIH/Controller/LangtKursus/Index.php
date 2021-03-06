<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_LangtKursus_Index extends k_Component
{
    private $dbquery;

    public $map = array('fag'                  => 'VIH_Controller_Fag_Index',
                        'elevchat'             => 'VIH_Controller_Kontakt_Elevchat',
                        'faq'                  => 'VIH_Controller_LangtKursus_Faq',
                        'praktiskeoplysninger' => 'VIH_Controller_LangtKursus_PraktiskeOplysninger',
                        'okonomi'              => 'VIH_Controller_LangtKursus_Okonomi',
                        'statsstotte'          => 'VIH_Controller_LangtKursus_Statsstotte',
                        'elevstotte'           => 'VIH_Controller_LangtKursus_Elevstotte',
                        'betalingsbetingelser' => 'VIH_Controller_LangtKursus_Betalingsbetingelser',
                        'hojskoleliv'          => 'VIH_Controller_LangtKursus_Hojskole',
                        'rejser'               => 'VIH_Controller_LangtKursus_Rejser',
                        'login'                => 'VIH_Controller_LangtKursus_Login_Index'
    );
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function wrapHtml($content)
    {
        $data = array('content' => $content);

        $tpl = $this->template->create('wrapper');
        return $tpl->render($this, $data);
    }

    function map($name)
    {
        if (!empty($this->map[$name])) {
            return $this->map[$name];
        }
        return 'VIH_Controller_LangtKursus_Show';
    }

    function renderHtml()
    {
        $title               = 'Lange højskolekurser';
        $meta['description'] = 'Præsentation af de lange højskolekursus på Vejle Idrætshøjskole. På kurserne får du en trøner- og lederuddannelse.';
        $meta['keywords']    = 'Idrætshøjskole, højskolekursus, højskolekurser, instruktør, instruktøruddannelse, lederuddannelse, trænerudddannelse, uddannelse, kursusoversigt, kurser, lange, efterår, forår, vinter, speciale, linjefag, liniefag, vinterkursus, skolestart';

        $kurser = VIH_Model_LangtKursus::getList('åbne');
        $next_kursus = VIH_Model_LangtKursus::getNext();

        $this->document->setTitle($title);
        $this->document->meta       = $meta;
        $this->document->widepicture = $this->url('/gfx/images/højskole.jpg');
        $this->document->theme      = 'langekurser';
        $this->document->body_class = 'widepicture';
        $this->document->feeds[]    = array('title' => 'Lange kurser',
                                            'link'  => $this->url('/rss/langekurser'));

        $data = array('summary' => 'Oversigt over de aktuelle lange kurser på Vejle Idrætshøjskole',
                      'caption' => 'Oversigt over aktuelle lange kurser',
                      'kurser'  => $kurser);

        $tpl = $this->template->create('LangtKursus/kurser');

        $content = array('content' => '
            <h1>Lange kurser</h1>
            <p class="clear">Gør dig klar til at tage livtag med resten af livet. Gør det for udfordringens skyld. En dag på Vejle Idrætshøjskole er nemlig aldrig en typisk dag &mdash; både når du vælger <a href="fag/">fag</a> og trives i hverdagen. Hvis du har nogle spørgsmål om de lange kurser kan du fx bruge vores <a href="'.$this->url('elevchat').'">elevchat</a>, <a href="'.$this->url('/kontakt').'">ringe til skolen</a> eller kontakte <a href="'.$this->url('/underviser').'">lærerne</a>.</p>
            '.  $tpl->render($this, $data) . '
            <p><a href="'.$this->url('/bestilling').'">Jeg vil hellere have en brochure at kigge i &rarr;</a></p>',
            'content_sub' => $this->getSubContent());

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $content);
    }

    function getSubContent()
    {
        $news = array('nyheder' => VIH_News::getList(''));
        $tpl = $this->template->create('News/sidebar-featured');
        return '
            <h2>Nyheder</h2>
            ' . $tpl->render($this, $news);
    }

    function renderXml()
    {
        $kurser = VIH_Model_LangtKursus::getList('open');
        $i = 0;
        $items = array();
        foreach ($kurser AS $kursus):
            $items[$i]['title'] = $kursus->get('kursusnavn');
            $items[$i]['description'] = $kursus->get('description');
            $items[$i]['pubDate'] = $kursus->get('date_updated_rfc822');
            $items[$i]['author'] = htmlspecialchars('Vejle Idrætshøjskole <kontor@vih.dk>');
            $items[$i]['link'] = 'http://vih.dk/langekurser/' . $kursus->get('id') . '/';
            $i++;
        endforeach;

        $data = array(
            'title' => 'Lange kurser på Vejle Idrætshøjskole',
            'link' => 'http://vih.dk/',
            'language' => 'da',
            'description' => 'Kursusoversigten over lange kurser på Vejle Idrætshøjskole',
            'docs' => 'http://vih.dk/rss/',
            'items' => $items);

        $tpl = $this->template->create('rss20');
        return $tpl->render($this, $data);
    }
}
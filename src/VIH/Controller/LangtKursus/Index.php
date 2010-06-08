<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_LangtKursus_Index extends k_Controller
{
    private $dbquery;

    public $map = array('fag'                  => 'VIH_Controller_Fag_Index',
                        'elevchat'             => 'VIH_Controller_Kontakt_Elevchat',
                        'faq'                  => 'VIH_Controller_LangtKursus_Faq',
                        'praktiskeoplysninger' => 'VIH_Controller_LangtKursus_PraktiskeOplysninger',
                        'okonomi'              => 'VIH_Controller_LangtKursus_Okonomi');

    function GET()
    {
        $title               = 'Lange højskolekurser';
        $meta['description'] = 'Præsentation af de lange højskolekursus på Vejle Idrætshøjskole. På kurserne får du en træner- og lederuddannelse.';
        $meta['keywords']    = 'idrætshøjskole, højskolekursus, højskolekurser, instruktør, instruktøruddannelse, lederuddannelse, trænerudddannelse, uddannelse, kursusoversigt, kurser, lange, efterår, forår, vinter, speciale, linjefag, liniefag, vinterkursus, skolestart';

        $kurser = VIH_Model_LangtKursus::getList('åbne');
        $next_kursus = VIH_Model_LangtKursus::getNext();

        $this->document->title      = $title;
        $this->document->meta       = $meta;
        $this->document->widepicture = $this->url('/gfx/images/hojskole.jpg');
        $this->document->theme      = 'langekurser';
        $this->document->body_class = 'widepicture';
        $this->document->feeds[]    = array('title' => 'Lange kurser',
                                            'link'  => $this->url('/rss/langekurser'));

        $data = array('summary' => 'Oversigt over de aktuelle lange kurser på Vejle Idrætshøjskole',
                      'caption' => 'Oversigt over aktuelle lange kurser',
                      'kurser'  => $kurser);

        $content = array('content' => '
            <h1>Lange kurser</h1>
            <p class="clear">Gør dig klar til at tage livtag med resten af livet. Gør det for udfordringens skyld. En dag på Vejle Idrætshøjskole er nemlig aldrig en typisk dag &mdash; både når du vælger <a href="fag/">fag</a> og trives i hverdagen. Hvis du har nogle spørgsmål om de lange kurser kan du fx bruge vores <a href="'.$this->url('elevchat').'">elevchat</a>, <a href="'.$this->url('/kontakt').'">ringe til skolen</a> eller kontakte <a href="'.$this->url('/underviser').'">lærerne</a>.</p>
            '.  $this->render('VIH/View/LangtKursus/kurser-tpl.php', $data) . '
            <p><a href="'.$this->url('/bestilling').'">Jeg vil hellere have en brochure at kigge i &rarr;</a></p>',
            'content_sub' => $this->getSubContent());

        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $content);
    }

    function getSubContent()
    {
        $news = array('nyheder' => VIH_News::getList(''));
        return '
            <h2>Nyheder</h2>
            ' . $this->render('VIH/View/News/sidebar-featured.tpl.php', $news);
    }

    function forward($name)
    {
        if ($name == 'elevchat') {
            $next = new VIH_Controller_Kontakt_Elevchat($this, $name);
        } elseif ($name == 'faq') {
            $next = new VIH_Controller_LangtKursus_Faq($this, $name);
        } elseif ($name == 'praktiskeoplysninger') {
            $next = new VIH_Controller_LangtKursus_PraktiskeOplysninger($this, $name);
        } elseif ($name == 'okonomi') {
            $next = new VIH_Controller_LangtKursus_Okonomi($this, $name);
        } elseif ($name == 'statsstotte') {
            $next = new VIH_Controller_LangtKursus_Statsstotte($this, $name);
        } elseif ($name == 'elevstotte') {
            $next = new VIH_Controller_LangtKursus_Elevstotte($this, $name);
        } elseif ($name == 'betalingsbetingelser') {
            $next = new VIH_Controller_LangtKursus_Betalingsbetingelser($this, $name);
        } elseif ($name == 'login') {
            $next = new VIH_Controller_LangtKursus_Login_Index($this, $name);
            $content = $next->handleRequest();
            return $this->render('VIH/View/wrapper-tpl.php', $data = array('content' => $content));
        } elseif ($name == 'hojskoleliv') {
            $next = new VIH_Controller_LangtKursus_Login_Hojskole($this, $name);
            return $next->handleRequest();
        } elseif ($name == 'rejser') {
            $next = new VIH_Controller_LangtKursus_Rejser($this, $name);
            return $next->handleRequest();
        } else {
            $next = new VIH_Controller_LangtKursus_Show($this, $name);
            return $next->handleRequest();
        }
        $data = array('content' => $next->handleRequest());

        return $this->render('VIH/View/wrapper-tpl.php', $data);
    }

    function handleRequest()
    {
        $this->document->trail[$this->name] = $this->url();
        return parent::handleRequest();
    }
}
<?php
class VIH_Controller_LangtKursus_Okonomi extends k_Component
{
    public $map = array('elevstøtte' =>  'vih_langekurser_controller_elevstøtte',
                          'statsstøtte' => 'vih_langekurser_controller_statsstøtte');

    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'Økonomi og priser';
        $meta['description'] = 'Oplysninger om Økonomi, priser og støttemuligheder, hvis du vælger et langt ophold på Vejle Idrætshøjskole.';
        $meta['keywords'] = 'elevbetaling, elevstøtte, kommunestøtte, lange, kurser, pris, omkostninger, koster, priser, ugepris, økonomi, støtte, elevstøtte, kommunestøtte, søg støtte, ansøgningsskema, betaling, skolepenge, penge, koster, omkostninger, brugerbetaling, fri ungdomsuddannelse, su, prisoversigt, hvad koster det, tilskud, ugepriser, kursusgebyret, prisliste, priser';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $data = array('kurser' => VIH_Model_LangtKursus::getList('åbne'));
        $tpl = $this->template->create('LangtKursus/okonomi');

        return '
        <h1>Økonomi</h1>
        <p>Hvis du har yderligere spørgsmål om økonomien i et langt højskoleophold, er du velkommen til at <a href="'.$this->url('/kontakt').'">ringe og snakke med kontoret</a>.</p>
        <h2>Elevbetaling</h2>
        <p>Du betaler et indmeldelsesgebyr på 1000 kroner for alle kursusperioder. Din betaling for opholdet omfatter kost, logi og undervisning. Der opkræves et yderligere beløb til udlandsrejse og materialer. Du kan se de præcise beløb under de kurser, du er interesseret i.</p>
        <p>Du kan finde det generelle prisniveau for højskolerne på <a href="http://www.hojskolerne.dk/">www.hojskolerne.dk</a>.</p>
        <p>Ugeprisen betaler du hver uge. De øvrige beløb er engangsbeløb.</p>
        '.$tpl->render($this, $data).'
        <h2>Individuel elevstøtte</h2>
        <p>Vejle Idrætshøjskole tilbyder gode støttemuligheder. Se mere om <a href="' . $this->url('elevstøtte') . '">kriterierne for at modtage støtte</a>. </p>
        <h2>Statsstøtte</h2>
        <p>Hvis du er indvandrer eller maksimalt har 10. klasse som uddannelse, kan du læse om <a href="'.$this->url('statsstøtte').'">flere støttemuligheder her</a>.</p>
        <h2>Kommunestøtte</h2>
        <p>Nogle kommuner støtter et højskoleophold, men reglerne er ikke ens i alle kommuner. Du kan tjekke om din kommune giver støtte på <a href="http://www.ffd.dk/da/main/main.php?menu=104#82">www.hojskolerne.dk</a> eller ved at <a href="'.htmlspecialchars('http://www.danmark.dk/kommuner.asp?page=gruppe&objno=350128').'">ringe til din kommune</a>. Du kan få tilsendt et ansøgningsskema af os ved at <a href="'.$this->url('/kontakt').'">ringe til kontoret eller skrive en e-mail</a>.</p>
        <h2>Støttemuligheder</h2>
        <p>Læs mere om dine muligheder for støtte på <a href="http://www.hojskolerne.dk/">www.hojskolerne.dk</a>.</p>
        ';
    }
}
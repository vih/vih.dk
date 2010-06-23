<?php
class VIH_Controller_LangtKursus_Okonomi extends k_Component
{
    public $map = array('elevstotte' =>  'vih_langekurser_controller_elevstotte',
                          'statsstotte' => 'vih_langekurser_controller_statsstotte');

    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'ï¿½konomi og priser';
        $meta['description'] = 'Oplysninger om ï¿½konomi, priser og stï¿½ttemuligheder, hvis du vï¿½lger et langt ophold pï¿½ Vejle Idrï¿½tshï¿½jskole.';
        $meta['keywords'] = 'elevbetaling, elevstï¿½tte, kommunestï¿½tte, lange, kurser, pris, omkostninger, koster, priser, ugepris, ï¿½konomi, stï¿½tte, elevstï¿½tte, kommunestï¿½tte, sï¿½g stï¿½tte, ansï¿½gningsskema, betaling, skolepenge, penge, koster, omkostninger, brugerbetaling, fri ungdomsuddannelse, su, prisoversigt, hvad koster det, tilskud, ugepriser, kursusgebyret, prisliste, priser';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $data = array('kurser' => VIH_Model_LangtKursus::getList('ï¿½bne'));
        $tpl = $this->template->create('LangtKursus/okonomi');

        return '
        <h1>ï¿½konomi</h1>
        <p>Hvis du har yderligere spï¿½rgsmï¿½l om ï¿½konomien i et langt hï¿½jskoleophold, er du velkommen til at <a href="'.url('/kontakt').'">ringe og snakke med kontoret</a>.</p>
        <h2>Elevbetaling</h2>
        <p>Du betaler et indmeldelsesgebyr pï¿½ 1000 kroner for alle kursusperioder. Din betaling for opholdet omfatter kost, logi og undervisning. Der opkrï¿½ves et yderligere belï¿½b til udlandsrejse og materialer. Du kan se de prï¿½cise belï¿½b under de kurser, du er interesseret i.</p>
        <p>Du kan finde det generelle prisniveau for hï¿½jskolerne pï¿½ <a href="http://www.hojskolerne.dk/">www.hojskolerne.dk</a>.</p>
        <p>Ugeprisen betaler du hver uge. De ï¿½vrige belï¿½b er engangsbelï¿½b.</p>
        '.$tpl->render($this, $data).'
        <h2>Individuel elevstï¿½tte</h2>
        <p>Vejle Idrï¿½tshï¿½jskole tilbyder gode stï¿½ttemuligheder. Se mere om <a href="' . $this->url('elevstotte') . '">kriterierne for at modtage stï¿½tte</a>. </p>
        <h2>Statsstï¿½tte</h2>
        <p>Hvis du er indvandrer eller maksimalt har 10. klasse som uddannelse, kan du lï¿½se om <a href="'.$this->url('statsstotte').'">flere stï¿½ttemuligheder her</a>.</p>
        <h2>Kommunestï¿½tte</h2>
        <p>Nogle kommuner stï¿½tter et hï¿½jskoleophold, men reglerne er ikke ens i alle kommuner. Du kan tjekke om din kommune giver stï¿½tte pï¿½ <a href="http://www.ffd.dk/da/main/main.php?menu=104#82">www.hojskolerne.dk</a> eller ved at <a href="'.htmlspecialchars('http://www.danmark.dk/kommuner.asp?page=gruppe&objno=350128').'">ringe til din kommune</a>. Du kan fï¿½ tilsendt et ansï¿½gningsskema af os ved at <a href="'.url('/kontakt').'">ringe til kontoret eller skrive en e-mail</a>.</p>
        <h2>Stï¿½ttemuligheder</h2>
        <p>Lï¿½s mere om dine muligheder for stï¿½tte pï¿½ <a href="http://www.hojskolerne.dk/">www.hojskolerne.dk</a>.</p>
        ';
    }
}
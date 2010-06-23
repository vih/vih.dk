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
        $title = '�konomi og priser';
        $meta['description'] = 'Oplysninger om �konomi, priser og st�ttemuligheder, hvis du v�lger et langt ophold p� Vejle Idr�tsh�jskole.';
        $meta['keywords'] = 'elevbetaling, elevst�tte, kommunest�tte, lange, kurser, pris, omkostninger, koster, priser, ugepris, �konomi, st�tte, elevst�tte, kommunest�tte, s�g st�tte, ans�gningsskema, betaling, skolepenge, penge, koster, omkostninger, brugerbetaling, fri ungdomsuddannelse, su, prisoversigt, hvad koster det, tilskud, ugepriser, kursusgebyret, prisliste, priser';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $data = array('kurser' => VIH_Model_LangtKursus::getList('�bne'));
        $tpl = $this->template->create('LangtKursus/okonomi');

        return '
        <h1>�konomi</h1>
        <p>Hvis du har yderligere sp�rgsm�l om �konomien i et langt h�jskoleophold, er du velkommen til at <a href="'.url('/kontakt').'">ringe og snakke med kontoret</a>.</p>
        <h2>Elevbetaling</h2>
        <p>Du betaler et indmeldelsesgebyr p� 1000 kroner for alle kursusperioder. Din betaling for opholdet omfatter kost, logi og undervisning. Der opkr�ves et yderligere bel�b til udlandsrejse og materialer. Du kan se de pr�cise bel�b under de kurser, du er interesseret i.</p>
        <p>Du kan finde det generelle prisniveau for h�jskolerne p� <a href="http://www.hojskolerne.dk/">www.hojskolerne.dk</a>.</p>
        <p>Ugeprisen betaler du hver uge. De �vrige bel�b er engangsbel�b.</p>
        '.$tpl->render($this, $data).'
        <h2>Individuel elevst�tte</h2>
        <p>Vejle Idr�tsh�jskole tilbyder gode st�ttemuligheder. Se mere om <a href="' . $this->url('elevstotte') . '">kriterierne for at modtage st�tte</a>. </p>
        <h2>Statsst�tte</h2>
        <p>Hvis du er indvandrer eller maksimalt har 10. klasse som uddannelse, kan du l�se om <a href="'.$this->url('statsstotte').'">flere st�ttemuligheder her</a>.</p>
        <h2>Kommunest�tte</h2>
        <p>Nogle kommuner st�tter et h�jskoleophold, men reglerne er ikke ens i alle kommuner. Du kan tjekke om din kommune giver st�tte p� <a href="http://www.ffd.dk/da/main/main.php?menu=104#82">www.hojskolerne.dk</a> eller ved at <a href="'.htmlspecialchars('http://www.danmark.dk/kommuner.asp?page=gruppe&objno=350128').'">ringe til din kommune</a>. Du kan f� tilsendt et ans�gningsskema af os ved at <a href="'.url('/kontakt').'">ringe til kontoret eller skrive en e-mail</a>.</p>
        <h2>St�ttemuligheder</h2>
        <p>L�s mere om dine muligheder for st�tte p� <a href="http://www.hojskolerne.dk/">www.hojskolerne.dk</a>.</p>
        ';
    }
}
<?php
/**
 * Korte kurser
 *
 * @package VIH
 * @author  Lars Olesen <lars@legestue.net>
 */
class VIH_Model_KortKursus
{
    private $standardpriser = array(
        'depositum' => KORTEKURSER_STANDARDPRISER_DEPOSITUM,
        'afbestillingsforsikring' => KORTEKURSER_STANDARDPRISER_AFBESTILLINGSFORSIKRING);

    private $status = array(
        'udsolgt' => 0,
        'faa_ledige_pladser' => 6);

    private $golf = array(
    	'begynderpladser' => 10,
   		'begynderhandicap' => 50);

    private $id;
    private $value = array();
    public $indkvartering = array(
        1 => 'efterskolen',
        2 => 'kursuscenteret',
        3 => 'hojskolen',
        4 => 'hojskole og kursuscenter'
    );
    public $venteliste;

    public $gruppe = array(
        1 => 'golf',
        2 => 'sommerhojskole',
        3 => 'bridge',
        4 => 'familiekursus',
        7 => 'senior',
        6 => 'fitness',
        5 => 'camp',
        8 => 'cykel',
        9 => 'kajak'
    );

    function isFamilyCourse()
    {
        if ($this->get('gruppe_id') == 2 OR $this->get('gruppe_id') == 4) {
            return true;
        }
        return false;
    }

    /**
     * Constructor
     *
     * @param integer $id Id
     */
    function __construct($id = 0)
    {
        $this->fields = array('navn', 'uge', 'pladser', 'vaerelser', 'type', 'gruppe_id', 'pris', 'boernepris', 'indkvartering', 'tekst', 'keywords', 'description', 'nyhed', 'pic_id', 'minimumsalder', 'gruppe_id', 'begyndere');
        $this->id = (int)$id;

        if ($this->id > 0) {
            $this->load();
        }
    }

    function ventelisteFactory($id = 0)
    {
        if ($this->id == 0) {
            return false;
        }
        // 1 = kortekurser
        return $this->venteliste = new VIH_Model_Venteliste(1, $this->id, $id);
    }

    /**
     * Load
     */
    function getKursusNavn()
    {
        return $this->get('navn') . ' uge ' . $this->get('uge') . ', ' . $this->get('aar');
    }

    function load()
    {
        $sql = "SELECT *,
                DATE_FORMAT(dato_start, '%Y') AS aar,
                DATE_FORMAT(dato_start, '%d-%m-%Y') AS dato_start_dk,
                DATE_FORMAT(dato_slut, '%d-%m-%Y') AS dato_slut_dk
            FROM kortkursus WHERE id = '" . $this->id . "' LIMIT 1";
        $db = new DB_Sql;

        $db->query($sql);
        if (!$db->nextRecord()) {
            return 0;
        }

        $this->id = $db->f("id");
        $this->value['begyndere'] = $db->f('begyndere');
        $this->value['id'] = $db->f('id');
        $this->value['navn'] = $db->f('navn');
        $this->value['kursusnavn'] = $db->f('navn') . ' uge ' . $db->f('uge') . ', ' . $db->f('aar');
        $this->value['minimumsalder'] = $db->f('minimumsalder');
        $this->value['uge'] = $db->f('uge');
        $this->value['date_updated_rfc822'] = strftime("%a, %d %b %Y %H:%I:%S %z", strtotime($db->f("date_updated")));
        $this->value['dato_start'] = $db->f('dato_start');
        $this->value['dato_slut'] = $db->f('dato_slut');
        $this->value['dato_start_dk'] = $db->f('dato_start_dk');
        $this->value['dato_slut_dk'] = $db->f('dato_slut_dk');
        $this->value['aar'] = $db->f('aar');
        $this->value['pladser'] = $db->f('pladser');
        $this->value['vaerelser'] = $db->f('vaerelser');
        $this->value['pic_id'] = $db->f('pic_id');
        $this->value['type'] = $db->f('type');
        $this->value['gruppe_id'] = $db->f('gruppe_id');
        $this->value['indkvartering_key'] = $db->f('indkvartering_key');
        if ($db->f('indkvartering_key')) {
            $this->value['indkvartering'] = $this->indkvartering[$db->f('indkvartering_key')];
        } else {
            $this->value['indkvartering'] = 'kursuscenter';
        }

        $this->value['pris'] = $db->f('pris');
        $this->value['pris_boern'] = $db->f('pris_boern');

        if (empty($this->value['pris_boern'])) {
            $this->value['pris_boern'] = $db->f('boernepris');
        }

        $this->value['pris_depositum'] = $db->f('pris_depositum');
        if (empty($this->value['pris_depositum'])) {
            $this->value['pris_depositum'] = $this->standardpriser['depositum'];
        }

        $this->value['pris_afbestillingsforsikring'] = $db->f('pris_afbestillingsforsikring');
        if (empty($this->value['afbestillingsforsikring'])) {
            $this->value['pris_afbestillingsforsikring'] = $this->standardpriser['afbestillingsforsikring'];
        }

        $this->value['beskrivelse'] = $db->f('beskrivelse');
        if (empty($this->value['beskrivelse'])) {
            $this->value['beskrivelse'] = $db->f('tekst');
        }

        $this->value['description'] = $db->f('description');
        $this->value['title'] = $db->f('title');
        if (empty($this->value['title'])) {
            $this->value['title'] = $this->get('kursusnavn');
        }
        $this->value['keywords'] = $db->f('keywords');

        $this->value['ansat_id'] = $db->f('ansat_id');

        if (empty($this->value['ansat_id'])) {
            $this->value['ansat_id'] = $db->f('underviser_id'); // skal slettes
        }

        $this->value['tilmeldingsmulighed'] = $db->f('tilmeldingsmulighed');
        $this->value['nyhed'] = $db->f('nyhed');
        $this->value['published'] = $db->f('published');

        return true;
    }

    function getGruppe()
    {
        return $this->gruppe[$this->get('gruppe_id')];
    }

    function get($key = '')
    {
        if (!empty($key)) {
            if (!array_key_exists($key, $this->value)) {
                return '';
            }
            return $this->value[$key];
        }

        return $this->value;
    }

    function save($var)
    {
        $save = array('date_updated = NOW()');

        foreach ($var as $key => $value) {
            $save[] = $key . " = '".$value."'";
        }

        if ($this->id > 0) {
            $sql_type = "UPDATE ";
            $sql_end = " WHERE id = ". $this->id;
        } else {
            $sql_type = "INSERT INTO ";
            $sql_end = ", date_created=NOW()";
        }
        $sql = $sql_type . "kortkursus SET " .
        implode(',', $save) . $sql_end;

        $db = new DB_Sql;
        $db->query($sql);

        if ($this->id == 0) {
            $this->id = $db->insertedId();
        }

        $this->load();

        return $this->id;
    }

    function copy($kursus)
    {
        $var['navn'] = $kursus->get('navn') . ' (kopi)';
        $var['uge'] = $kursus->get('uge');
        $var['dato_start'] = $kursus->get('dato_start');
        $var['dato_slut'] = $kursus->get('dato_slut');
        $var['nyhed'] = $kursus->get('nyhed');
        $var['description'] = $kursus->get('description');
        $var['beskrivelse'] = $kursus->get('beskrivelse');
        $var['minimumsalder'] = $kursus->get('minimumsalder');
        $var['ansat_id'] = $kursus->get('ansat_id');
        $var['begyndere'] = $kursus->get('begyndere');
        $var['title'] = $kursus->get('title');
        $var['keywords'] = $kursus->get('keywords');
        $var['tekst'] = $kursus->get('tekst');
        $var['type'] = $kursus->get('type');
        $var['gruppe_id']	= $kursus->get('gruppe_id');
        $var['underviser_id'] = $kursus->get('underviser_id');
        $var['pris'] = $kursus->get('pris');
        $var['pris_boern'] = $kursus->get('pris_boern');
        $var['pris_depositum'] = $kursus->get('pris_depositum');
        $var['pris_afbestillingsforsikring'] = $kursus->get('pris_afbestillingsforsikring');
        $var['indkvartering_key'] = $kursus->get('indkvartering_key');
        $var['pladser'] = $kursus->get('pladser');
        $var['vaerelser'] = $kursus->get('vaerelser');
        $var['pic_id'] = $kursus->get('pic_id');
        $var['status'] = $kursus->get('status');
        $var['tilmeldingsmulighed'] = $kursus->get('status');
        $var['published'] = 0; // aldrig udgive dem f�r de er blevet kigget igennem

        $new_kursus = new VIH_Model_KortKursus();
        if ($id = $new_kursus->save($var)) {
            $gateway = new VIH_Model_KortKursus_Indkvartering($new_kursus);

            foreach ($this->getIndkvartering() as $indkvartering) {
                $gateway->activate($indkvartering['indkvartering_key'], $indkvartering['price']);
            }
        }
        return $id;
    }


    /**
     * Henter alle de �bne kurser
     *
     * Skal g�res mere dynamisk
     */
    function getList($type = 'open', $gruppe = '')
    {
        $kurser = array();

        switch ($type) {

            case 'old':
                $sql = "SELECT id
                                    FROM kortkursus
                                    WHERE kortkursus.published = 1
                                        AND tilmeldingsmulighed='Ja'
                                        AND dato_start < NOW()";


                break;
            case 'intranet':
                // kortkursus.published = 1 AND tilmeldingsmulighed='Ja' AND
                $sql = "SELECT id
                                    FROM kortkursus
                                    WHERE
                                        dato_slut > DATE_SUB(NOW(), INTERVAL 14 DAY)";
                break;
            case 'open':
                // fall through
            default:
                $sql = "SELECT id
                                    FROM kortkursus
                                    WHERE kortkursus.published = 1
                                        AND tilmeldingsmulighed='Ja'
                                        AND dato_start >= DATE_FORMAT(NOW(), '%Y-%m-%d')";

                break;

        }

        switch ($gruppe) {
            case "golf":
                $sql .= " AND gruppe_id=1";
                break;
            case "bridge":
                $sql .= " AND gruppe_id=3";
                break;
            case "kajak":
                $sql .= " AND gruppe_id=9";
                break;
            case "others":
                $sql .= " AND (gruppe_id <> 1 AND gruppe_id <> 3)";
                break;
            case "sommerhojskole":
                $sql .= " AND (DATE_FORMAT(dato_start, '%m-d%') > '06-28' AND DATE_FORMAT(dato_slut, '%m-d%') < '09-08')";
                break;
            case "familiekursus":
                $sql .= " AND gruppe_id = 4";
                break;
            case "voksen":
                $sql .= " AND type='Voksenkursus'";
                break;
            case "senior":
                $sql .= " AND type='Seniorkursus'";
                break;
            case 'camp':
                $sql .= " AND gruppe_id = 5";
                break;
            case 'cykel':
                $sql .= " AND gruppe_id = 8";
                break;

        }

        $sql .= " ORDER BY dato_start, gruppe_id ASC";
        $db = new DB_Sql;
        $db->query($sql);
        $i = 0;
        $kursus = array();
        while ($db->nextRecord()) {
            $kursus[$i] = new VIH_Model_KortKursus($db->f('id'));
            $kursus[$i]->getPladser();
            $kursus[$i]->ventelisteFactory();
            $i++;
        }

        return $kursus;
    }

    ################################################################################
    # SPECIELLE METODER                                                            #
    ################################################################################

    /**
     * Henter alle tilmeldinger p� et kursus
     *
     * @return array med id'er over deltagere p� et kursus
     */
    function getTilmeldinger()
    {
        $db = new DB_Sql;
        $db->query("SELECT id FROM kortkursus_tilmelding tilmelding
            WHERE tilmelding.active = 1 AND tilmelding.status_key >= 2 AND tilmelding.status_key <= 4
                AND tilmelding.kortkursus_id = " . $this->id);
        $list = array();
        $i = 0;
        while($db->nextRecord()) {
            $list[$i] = new VIH_Model_KortKursus_Tilmelding($db->f('id'));
            $list[$i]->loadPris();
            $list[$i]->loadBetaling();
            $i++;
        }
        return $list;
    }

    /**
     * Henter alle deltagerne p� et kursus
     *
     * @todo Kunne lige s� godt returnere et array over alle deltagerne?
     *
     * @return array med id'er over deltagere p� et kursus
     */
    function getDeltagere()
    {
        $db = new DB_Sql;

        // v�lger alle tilmeldte kursister
        $sql = "SELECT deltager.id AS id,
                tilmelding.id AS tilmelding_id
            FROM kortkursus_deltager_ny deltager
            INNER JOIN kortkursus_tilmelding tilmelding
                ON tilmelding.id = deltager.tilmelding_id
            WHERE (tilmelding.status_key >= 2 AND tilmelding.status_key <=4)
                AND tilmelding.active = 1
                AND deltager.active = 1
                AND tilmelding.kortkursus_id = " .$this->id . "
            ORDER BY deltager.tilmelding_id ASC";

        $db->query($sql);
        $deltager = array();
        $i = 0;
        while ($db->nextRecord()) {
            $deltager[$i] = new VIH_Model_KortKursus_Tilmelding_Deltager(new VIH_Model_KortKursus_Tilmelding($db->f('tilmelding_id')), $db->f('id'));
            $i++;
        }
        return $deltager;
    }

    /**
     * T�ller antallet af optagne pladser
     * Funktionen skal ogs� tage h�jde for dem, der er ved at tilmelde sig.
     * Derfor bruger vi status >= 1
     *
     * $status[1] = 'undervejs'
     * $status[2] = 'reserveret'
     * $status[3] = 'tilmeldt' // n�r man har betalt depositum
     *
     * @todo Kan denne funktion optimeres?
     */
    function getPladser($key = '')
    {
        $sql = "SELECT count(*) AS antal
            FROM kortkursus_deltager_ny deltager
            INNER JOIN kortkursus_tilmelding tilmelding
                ON deltager.tilmelding_id = tilmelding.id
            WHERE tilmelding.kortkursus_id =" . $this->id . "
                AND (tilmelding.status_key >= 1 AND tilmelding.status_key <= 4)
                AND tilmelding.active = 1 AND deltager.active = 1";

        $db = new DB_Sql;
        $db->query($sql);

        if (!$db->nextRecord()) {
            return array();
        }

        $this->value['pladser_optagne'] = $db->f('antal');
        $this->value['pladser_ledige'] = $this->get('pladser') - $this->value['pladser_optagne'];

        if ($this->get('pladser') > 0) {
            $this->value['pladser_procent_fyldt'] = round(($this->get('pladser') - $this->value['pladser_ledige']) / $this->get('pladser') * 100, 0);
        } else {
            $this->value['pladser_procent_fyldt'] = '';
        }

        if ($this->value['pladser_ledige'] < $this->status['faa_ledige_pladser'] AND $this->value['pladser_ledige'] > $this->status['udsolgt']) {
            $this->value['pladser_status'] = 'Få ledige pladser';
        } elseif ($this->value['pladser_ledige'] <= $this->status['udsolgt']) {
            $this->value['pladser_status'] = 'Udsolgt';
        } else {
            $this->value['pladser_status'] = 'Ledige pladser';
        }

        return $this->get($key);
    }

    /**
     * Bruges s�rligt til golfkurserne
     * T�ller med baggrund i handicap
     *
     * @todo Denne funktion skal optimeres, s� den ikke f�rst genneml�ber alle tilmeldingerne,
     *       og derefter genneml�ber alle deltagerne, inden den kan finde antallet af begyndere.
     *
     * Denne funktion skal skrives helt om for at kunne finde begynderne. Enten skal statuskoderne
     * hardkodes ind, eller ogs� skal status g�res tilg�ngeligt uden om Tilmelding - evt ved at status
     * arrayet er tilg�ngelig p� anden m�de
     *
     * Regler:
     * - man er begynder, hvis man har et handicap st�rre end eller lig med 54
     * - man er begynder, hvis man ikke har dgu-medlemskab
     */
    function getBegyndere()
    {
        if ($this->get('gruppe_id') != 1) {
            return 0;
        }

        $sql = "SELECT count(*) AS antal
            FROM kortkursus_deltager_oplysninger_ny
            INNER JOIN kortkursus_deltager_ny deltager ON deltager.id =  kortkursus_deltager_oplysninger_ny.deltager_id
            INNER JOIN kortkursus_tilmelding tilmelding
                ON deltager.tilmelding_id = tilmelding.id
            INNER JOIN kortkursus
                ON kortkursus.id = tilmelding.kortkursus_id
            WHERE tilmelding.kortkursus_id =" . $this->id . "
                AND (tilmelding.status_key >= 1 AND tilmelding.status_key <= 4)
                AND tilmelding.active = 1 AND deltager.active = 1 AND (kortkursus_deltager_oplysninger_ny.art = 'handicap' AND kortkursus_deltager_oplysninger_ny.indhold > ".$this->golf['begynderhandicap'].")";

        $db = new DB_Sql;
        $db->query($sql);

        if (!$db->nextRecord()) {
            return 0;
        }

        $this->value['pladser_begyndere'] = $db->f('antal');
        $this->value['pladser_begyndere_ledige'] = $this->get('begyndere') - $this->value['pladser_begyndere'];

        return $this->value['pladser_begyndere'];
    }

    /**
     * Specielt til familiekurserne
     * Bruges til at udregne om der er nok ledige v�relser:
     * Regler:
     * - Personer over 2 �r udl�ser en seng
     * - Flere end tre personer p� en tilmelding udl�ser en seng
     * @see	Tilmelding
     */
    function getVaerelser()
    {
        $vaerelser = 0;
        $sql = "SELECT id FROM kortkursus_tilmelding WHERE kortkursus_id = " . $this->id . " AND active = 1";
        $db = new DB_Sql;
        $db->query($sql);
        while ($db->nextRecord()) {
            $tilmelding = new VIH_Model_KortKursus_Tilmelding($db->f('id'));
            $vaerelser += $tilmelding->getVaerelser();
        }
        return $this->get('vaerelser') - $vaerelser;
    }

    /**
     * Tilmeldingsstatistik
     *
     * Denne skal g�res dynamisk, s� vi kan tage perioder - knyttes evt. sammen med getList()
     */
    function statistik($filter = '')
    {
        // t�l antallet af pladser p� korte kurser
        $countPladser = 0;
        $countOptagne = 0;

        $db1 = new DB_Sql;

        $sql = "SELECT id, pladser FROM kortkursus
            WHERE published=1
                AND tilmeldingsmulighed = 'Ja'
                AND DATE_FORMAT(dato_start, '%Y') >= 2005";
        if (!empty($filter)) {
            $sql .= "	AND gruppe_id = " . (int)$filter;
        }

        $sql .= " ORDER BY dato_start ASC";

        $db1->query($sql);

        while ($db1->nextRecord()) {
            $countPladser += $db1->f('pladser');
            $kursus = new VIH_Model_KortKursus($db1->f('id'));
            $countOptagne += $kursus->getOptagnePladser();
        }

        if ($countPladser == 0) {
            $countPladser = 1;
        }

        $percent = round(($countOptagne / $countPladser) * 100, 0);

        return array(
            'pladser' => $countPladser,
            'percent' => $percent,
            'optagne' => $countOptagne
        );

    }

    function getLastModified()
    {
        $db = new DB_Sql;
        $db->query("SELECT date_updated FROM kortkursus ORDER BY date_updated DESC LIMIT 1");
        if (!$db->nextRecord()) {
            return 0;
        }
        return $db->f("date_updated");
    }

    function getId()
    {
        return $this->id;
    }

    function getIndkvartering()
    {
        $out = array();
        $gateway = new VIH_Model_KortKursus_Indkvartering($this);
        foreach ($gateway->getActive() as $key => $indkvartering) {
            $pris = '';
            if ($indkvartering['price'] <> 0) {
                 $pris = ', (' . $indkvartering['price'] . ' kr)';
            }
            $out[] = array(
                'indkvartering_key' => $indkvartering['indkvartering_key'],
                'text' => $gateway->getType($indkvartering['indkvartering_key']) . $pris,
                'price' => $indkvartering['price']
            );
        }
        return $out;
    }
}
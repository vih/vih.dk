<?php
/**
 * Short courses
 *
 * @package VIH
 * @author  Lars Olesen <lars@legestue.net>
 */
class VIH_Model_KortKursus
{
    protected $standardpriser = array(
        'depositum' => KORTEKURSER_STANDARDPRISER_DEPOSITUM);

    protected $status = array(
        'udsolgt' => 0,
        'faa_ledige_pladser' => 6);

    protected $golf = array(
    	'begynderpladser' => 10,
   		'begynderhandicap' => 50);

    protected $id;
    protected $value = array();
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

    /**
     * Constructor
     *
     * @param integer $id Id
     *
     * @return void
     */
    function __construct($id = 0)
    {
        $this->fields = array('navn', 'uge', 'pladser', 'vaerelser', 'type', 'gruppe_id', 'pris', 'boernepris', 'indkvartering', 'tekst', 'keywords', 'description', 'nyhed', 'pic_id', 'minimumsalder', 'gruppe_id', 'begyndere');
        $this->id = (int)$id;

        if ($this->id > 0) {
            $this->load();
        }
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

        if (!isset($this->value['pris_boern'])) {
            $this->value['pris_boern'] = $db->f('boernepris');
        }

        $this->value['pris_depositum'] = $db->f('pris_depositum');
        if (!isset($this->value['pris_depositum'])) {
            $this->value['pris_depositum'] = $this->standardpriser['depositum'];
        }

        $this->value['pris_afbestillingsforsikring'] = $db->f('pris_afbestillingsforsikring');
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
        $var['published'] = 0; // never publish before checked out

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
     * Gets courses
     *
     * @deprecated
     *
     * @return array
     */
    function getList($type = 'open', $gruppe = '')
    {
        $gateway = new VIH_Model_KortKursusGateway(new DB_Sql);
        return $gateway->getList($type, $gruppe);
    }

    function isFamilyCourse()
    {
        if ($this->get('gruppe_id') == 2 OR $this->get('gruppe_id') == 4) {
            return true;
        }
        return false;
    }

    function ventelisteFactory($id = 0)
    {
        if ($this->id == 0) {
            return false;
        }
        // 1 = kortekurser
        return $this->venteliste = new VIH_Model_Venteliste(1, $this->id, $id);
    }

    function getKursusNavn()
    {
        return $this->get('navn') . ' uge ' . $this->get('uge') . ', ' . $this->get('aar');
    }

    function getGruppe()
    {
        return $this->gruppe[$this->get('gruppe_id')];
    }

    /**
     * Gets registrations for a course
     *
     * @return array with objects
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
     * Gets participants for a course
     *
     * @return array with objects
     */
    function getDeltagere()
    {
        $db = new DB_Sql;
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
     * Counts spots for a course
     *
     * Also counts people in the registration process,
     * therefore status >= 1
     *
     * $status[1] = 'undervejs'
     * $status[2] = 'reserveret'
     * $status[3] = 'tilmeldt' // when deposit has been paid
     *
     * @todo Optimize?
     *
     * @param string $key
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
     * Counts beginners for golf courses
     *
     * @todo Optimize
     *
     * Rules, beginner when:
     * - handicap > 54
     * - if not dgu membership
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
     * Gets vacant rooms for family courses
     *
     * Rules, a bed is needed when:
     * - older than two years
     * - more than three persons = another room
     *
     * @see	Tilmelding
     *
     * @return integer
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
     * Statistics
     *
     * @todo Optimize
     */
    function statistik($filter = '')
    {
        // count number of spots on each course
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

    function hasCancellationFee()
    {
        return ($this->value['pris_afbestillingsforsikring'] > 0);
    }
}
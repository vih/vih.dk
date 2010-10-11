<?php
/**
 * Tilmelding til lange kurser
 *
 * @package VIH
 * @author  Lars Olesen <lars@legestue.net>
 */
require_once 'VIH/functions.php';

class VIH_Model_LangtKursus_Tilmelding
{
    public $betaling_loaded = false;
    protected $id = 0;
    public $kursus;
    public $value = array(); //holdliste needs this public
    protected $betalt;           // benyttes til at gemme hvor meget der er betalt mellem flere kald af getBetalt();
    public $betalingsobject;  // bruges bl.a. af kundelogin

    public $status = array(
        -3 => 'slettet',        // hvis den er slettet inde fra systemet
        -2 => 'afbrudt ophold', // hvis opholdet afbrydes
        -1 => 'annulleret',     // annulleret under tilmeldingsproceduren
        0 => 'ikke tilmeldt',   // standardindstillingen
        1 => 'undervejs',       // n�r man er ved at tilmelde sig
        2 => 'reserveret',      // n�r man har bekr�ftet at man vil tilmelde sig
        3 => 'tilmeldt',        // f�rst n�r man har betalt indmeldelsesgebyret
        4 => 'afsluttet'        // n�r alt er blevet betalt
    );

    public $uddannelse = array(
        1 => 'Folkeskole',
        2 => 'Gymnasium',
        5 => 'Handelsskole',
        3 => 'HF',
        4 => 'Andet'
    );

    public $betaling = array(
        1 => 'Egne midler / forældres',
        2 => 'Arbejdsløshedskasse',
        3 => 'Kontanthjælp',
        4 => 'andet'
    );

    public $sex = array(
        1 => 'Kvinde',
        2 => 'Mand'
    );

    function __construct($id = 0)
    {
        $this->id = (int)$id;

        $this->value['betalt'] = 'ikke loadet';
        $this->value['betalt_not_approved'] = 'ikke loadet';
        $this->value['saldo'] = 'ikke loadet';
        $this->value['skyldig_depositum'] = 'ikke loadet';
        $this->value['skyldig'] = 'ikke loadet';

        if ($this->id > 0) {
            $this->load();
        }
    }

    function factory($handle)
    {
        $handle = mysql_escape_string($handle);
        $handle = strip_tags($handle);
        $handle = trim($handle);

        if (empty($handle)) {
            return false;
        }

        $db = new DB_Sql;
        $db->query("SELECT id FROM langtkursus_tilmelding WHERE code='".$handle."'");
        if ($db->numRows() == 1 AND $db->nextRecord()) {
            return new VIH_Model_LangtKursus_Tilmelding($db->f('id'));
        }
        return false;

    }

    /**
     * Returnerer v�rdier
     *
     * @param string $key Key to return
     *
     * @return string
     */
    function get($key = '')
    {
        if (!empty($key)) {
            if (!empty($this->value[$key])) {
                return $this->value[$key];
            }
            else {
                return '';
            }
        }
        return $this->value;
    }

    function getKursus()
    {
        return new VIH_Model_LangtKursus($this->get('kursus_id'));
    }

    /**
     * Loader v�rdier
     *
     * @return integer
     */
    function load()
    {
        if ($this->id == 0) {
            return 0;
        }

        $sql = "SELECT *, DATE_FORMAT(date_created, '%d-%m-%Y') AS date_created_dk,
            DATE_FORMAT(dato_start, CONCAT(
                '%d. ',
                ELT(
                    MONTH(dato_start), 'januar', 'februar', 'marts', 'april', 'maj', 'juni', 'juli', 'august', 'september', 'oktober', 'november', 'december'
                ),
                ' %Y'
            )) AS dato_start_dk_streng,
            DATE_FORMAT(dato_slut, CONCAT(
                '%d. ',
                ELT(
                    MONTH(dato_slut), 'januar', 'februar', 'marts', 'april', 'maj', 'juni', 'juli', 'august', 'september', 'oktober', 'november', 'december'
                ),
                ' %Y'
            )) AS dato_slut_dk_streng,
            DATE_FORMAT(dato_start, '%d-%m-%Y') AS dato_start_dk,
            DATE_FORMAT(dato_slut, '%d-%m-%Y') AS dato_slut_dk
            FROM langtkursus_tilmelding
            WHERE id = " . $this->id;
        $db = new DB_Sql;
        $db->query($sql);
        if (!$db->nextRecord()) {
            return 0;
        }

        $this->id = $db->f('id');
        $this->kursus = new VIH_Model_LangtKursus($db->f('kursus_id'));

        if ($db->f('adresse_id') > 0) {
            $adresse = new VIH_Model_Adresse($db->f('adresse_id'));
            // skal lige overskrives, s� den ikke t�mmer arrayet
            $this->value['navn'] = $adresse->get('navn');
            $this->value['adresse'] = $adresse->get('adresse');
            $this->value['postnr'] = $adresse->get('postnr');
            $this->value['postby'] = $adresse->get('postby');
            $this->value['email'] = $adresse->get('email');
            $this->value['mobil'] = $adresse->get('mobil');
            $this->value['telefon'] = $adresse->get('telefon');
            //$this->value['arbejdstelefon'] = $adresse->get('arbejdstelefon');
        }

        $this->value['vaerelse'] = $db->f('vaerelse');

        if ($db->f('kontakt_adresse_id') > 0) {
            $kontakt_adresse = new VIH_Model_Adresse($db->f('kontakt_adresse_id'));
            $this->value['kontakt_navn'] = $kontakt_adresse->get('navn');
            $this->value['kontakt_adresse'] = $kontakt_adresse->get('adresse');
            $this->value['kontakt_postnr'] = $kontakt_adresse->get('postnr');
            $this->value['kontakt_postby'] = $kontakt_adresse->get('postby');
            $this->value['kontakt_email'] = $kontakt_adresse->get('email');
            $this->value['kontakt_mobil'] = $kontakt_adresse->get('mobil');
            $this->value['kontakt_telefon'] = $kontakt_adresse->get('telefon');
            $this->value['kontakt_arbejdstelefon'] = $kontakt_adresse->get('arbejdstelefon');
        }

        $this->value['id'] = $db->f('id');
        $this->value['session_id'] = $db->f('session_id');
        $this->value['kursus_id'] = $db->f('kursus_id');
        $this->value['cpr'] = $db->f('cpr');
        $this->value['birthday'] = getBirthday($db->f('cpr'));
        $this->value['age'] = $this->getAge();

        $this->value['adresse_id'] = $db->f('adresse_id');
        $this->value['kontakt_adresse_id'] = $db->f('kontakt_adresse_id');

        $this->value['kursus_id'] = $db->f('kursus_id');
        $this->value['cpr'] = $db->f('cpr');
        $this->value['besked'] = $db->f('besked');
        $this->value['status_key'] = $db->f('status_key');
        $this->value['status'] = $this->status[$db->f('status_key')];
        $this->value['active'] = $db->f('active');
        if ($db->f('uddannelse')) {
            $this->value['uddannelse'] = $this->uddannelse[$db->f('uddannelse')];
        } else {
            $this->value['uddannelse'] = 'Ingen';
        }
        $this->value['uddannelse_key'] = $db->f('uddannelse');
        $this->value['nationalitet'] = $db->f('nationalitet');
        $this->value['kommune'] = $db->f('kommune');
        $this->value['date_created'] = $db->f('date_created');
        $this->value['date_created_dk'] = $db->f('date_created_dk');
        //$this->value['rabat'] = $db->f('rabat');
        $this->value['kompetencestotte'] = $db->f('kompetencestotte');
        $this->value['elevstotte'] = $db->f('elevstotte');
        $this->value['ugeantal_elevstotte'] = $db->f('ugeantal_elevstotte');
        $this->value['kommunestotte'] = $db->f('kommunestotte');

        $this->value['statsstotte'] = $db->f('statsstotte');
        $this->value['aktiveret_tillaeg'] = $db->f('aktiveret_tillaeg');
        $this->value['pris_afbrudt_ophold'] = $db->f('pris_afbrudt_ophold');
        $this->value['code'] = $db->f('code');
        $this->value['pic_id'] = $db->f('pic_id');

        $this->value['sex'] = $db->f('sex');

        $this->value['ugeantal'] = $db->f('ugeantal');
        $this->value['pris_uge'] = $db->f('pris_uge');
        $this->value['pris_tilmeldingsgebyr'] = $db->f('pris_tilmeldingsgebyr');
        $this->value['dato_start'] = $db->f('dato_start');
        $this->value['dato_start_dk'] = $db->f('dato_start_dk');
        $this->value['dato_start_dk_streng'] = $db->f('dato_start_dk_streng');
        $this->value['dato_slut'] = $db->f('dato_slut');
        $this->value['dato_slut_dk'] = $db->f('dato_slut_dk');
        $this->value['dato_slut_dk_streng'] = $db->f('dato_slut_dk_streng');
        $this->value['pris_materiale'] = $db->f('pris_materiale');
        $this->value['pris_noegledepositum'] = $db->f('pris_noegledepositum');
        $this->value['pris_rejsedepositum'] = $db->f('pris_rejsedepositum');
        $this->value['pris_rejserest'] = (float)$db->f('pris_rejserest');
        $this->value['pris_rejselinje'] = $db->f('pris_rejselinje');
        $this->value['pris_total'] =
            $this->get('pris_tilmeldingsgebyr')
            + ($this->get("ugeantal") * $this->get("pris_uge"))
            + $this->get("pris_materiale")
            + $this->get("pris_rejsedepositum")
            + $this->get("pris_rejselinje")
            + $this->get("pris_noegledepositum")
            + $this->get("aktiveret_tillaeg")
            - $this->get("elevstotte") * $this->get('ugeantal_elevstotte')
            - $this->get("statsstotte") * $this->get('ugeantal')
            - $this->get("kompetencestotte") * $this->get('ugeantal')
            - $this->get('kommunestotte')
            + $this->get("pris_afbrudt_ophold")
            + $this->get('pris_rejserest');

        $this->value['betaling_key'] = $db->f('betaling');
        if ($this->value['betaling_key']) {
            $this->value['betaling'] = $this->betaling[$db->f('betaling')];
        } else {
            $this->value['betaling'] = 'Ingen';
        }
        // hvad bruges fag id til?
        $this->value['fag_id'] = $db->f('fag_id');

        $this->value['tekst_diplom'] = $db->f('tekst_diplom');
        if (empty($this->value['tekst_diplom'])) {
            $this->value['tekst_diplom'] = $this->kursus->get('tekst_diplom');
        }

        if (!$this->get('code')) {
            $db->query("UPDATE langtkursus_tilmelding SET code = '".vih_random_code(12)."' WHERE id = " . $this->id);
        }

        return ($this->id = $db->f('id'));
    }

    /**
     * Bruges til at slette tilmeldinger
     *
     * Tilmeldinger m� aldrig slettes helt fra databasen.
     *
     * @return boolean
     */
    function delete()
    {
        if ($this->id == 0) {
            return false;
        }
        $db = new DB_Sql;
        $db->query("UPDATE langtkursus_tilmelding SET date_updated = NOW(), active = 0, status_key = ".$this->getStatusKey('slettet')." WHERE id = " . $this->id);
        return true;
    }

    function validate($var)
    {
        $return = true;
        /*
        if (!Validate::number($var['uddannelse'])) $return = false;
        if (!Validate::number($var['kursus_id'], array('min' => 1))) $return = false;
        if (!Validate::number($var['betaling'])) $return = false;
        if (!Validate::string($var['cpr'], array('min_length' => 10))) $return = false;
        if (!Validate::string($var['nationalitet'], array('min_length' => 1))) $return = false;
        if (!Validate::string($var['kommune'], array('min_length' => 1))) $return = false;
        if (!Validate::number($var['fag_id'], array('min' => 1))) $return = false;
        */
        return $return;

    }

    /**
     * Bruges til at gemme ordren
     *
     * @param array $var Array to save
     */
    function save($var)
    {
        if (!empty($var['cpr'])) {
            $var['cpr'] = str_replace('-', '', $var['cpr']);
        } else {
            $var['cpr'] = '';
        }

        if (!$this->validate($var)) {
            return false;
        }

        // adressen
        $adresse = new VIH_Model_Adresse((int)$this->get('adresse_id'));
        $adresse_id = $adresse->save($var);

        $kontakt_adresse = new VIH_Model_Adresse($this->get('kontakt_adresse_id'));
        $kontakt_adresse_id = $kontakt_adresse->save(
            array(
                'navn' => $var['kontakt_navn'],
                'adresse' => $var['kontakt_adresse'],
                'postnr' => $var['kontakt_postnr'],
                'postby' => $var['kontakt_postby'],
                'telefonnummer' => $var['kontakt_telefon'],
                'arbejdstelefon' => $var['kontakt_arbejdstelefon'],
                'mobil' => '',
                'email' => $var['kontakt_email']
            )
        );

        $bind['status_key'] = $this->getStatusKey('undervejs');
        $bind['adresse_id'] = $adresse_id;
        $bind['kontakt_adresse_id'] = $kontakt_adresse_id;
        $bind['besked'] = $var['besked'];
        $bind['uddannelse'] = $var['uddannelse'];
        $bind['kursus_id'] = $var['kursus_id'];
        $bind['betaling'] = $var['betaling'];
        $bind['cpr'] = $var['cpr'];
        $bind['nationalitet'] = $var['nationalitet'];
        $bind['kommune'] = $var['kommune'];
        if (!empty($var['sex'])) $bind['sex'] = $var['sex'];

        $conn = Doctrine_Manager::connection(DB_DSN);
        $conn->setCharset('utf8');
        $table = Doctrine::getTable('VIH_Model_Course_Registration');
        $tilmelding = $table->findOneById($this->id);

        if (empty($tilmelding)) {
        	$tilmelding = new VIH_Model_Course_Registration;
        }

        $tilmelding->fromArray($bind);
        $tilmelding->save();

        if ($this->id == 0) {
            $this->id = $tilmelding->id;
        }

        $this->load();

        return $this->id;
    }

    function savePicture($pic_id)
    {
        if ($this->id == 0) {
            return false;
        }
        $db = new DB_Sql;
        $db->query("UPDATE langtkursus_tilmelding SET pic_id = " . (int)$pic_id . " WHERE id = " . $this->id);
        return true;
    }

    function savePriser($var)
    {
        if ($this->id == 0) {
            return false;
        }

        settype($var['elevstotte'], 'string');
        settype($var['ugeantal_elevstotte'], 'string');
        settype($var['statsstotte'], 'string');
        settype($var['kommunestotte'], 'string');
        settype($var['aktiveret_tillaeg'], 'string');
        settype($var['kompetencestotte'], 'string');
        settype($var['pris_afbrudt_ophold'], 'string');

        $bind['elevstotte'] = $var['elevstotte'];
        $bind['ugeantal_elevstotte'] = $var['ugeantal_elevstotte'];
        $bind['statsstotte'] = $var['statsstotte'];
        $bind['kommunestotte'] =  $var['kommunestotte'];
        $bind['aktiveret_tillaeg'] = $var['aktiveret_tillaeg'];
        $bind['kompetencestotte'] = $var['kompetencestotte'];
        $bind['pris_uge'] = $var['pris_uge'];
        $bind['ugeantal'] = $var['ugeantal'];
        $bind['pris_tilmeldingsgebyr'] = $var['pris_tilmeldingsgebyr'];
        $bind['pris_materiale'] = $var['pris_materiale'];
        $bind['pris_rejsedepositum'] = $var['pris_rejsedepositum'];
        $bind['pris_rejserest'] = $var['pris_rejserest'];
        $bind['pris_rejselinje'] = $var['pris_rejselinje'];
        $bind['pris_noegledepositum'] = $var['pris_noegledepositum'];
        $bind['dato_start'] = $var['dato_start'];
        $bind['dato_slut'] = $var['dato_slut'];
        $bind['pris_afbrudt_ophold'] = $var['pris_afbrudt_ophold'];

        $conn = Doctrine_Manager::connection(DB_DSN);
        $conn->setCharset('utf8');
        $tilmelding = Doctrine::getTable('VIH_Model_Course_Registration')->findOneById($this->id);
        $tilmelding->fromArray($bind);
        $tilmelding->save();

        $this->load();
        return true;
    }

    function setCode()
    {
        $db = new DB_Sql;
        $random_code = vih_random_code(12);
        $db->query("SELECT * FROM langtkursus_tilmelding WHERE code = '".$random_code."'");
        if ($db->numRows() > 0) {
            $random_code = vih_random_code(12);
        }
        $db->query("UPDATE langtkursus_tilmelding SET code = '".$random_code."' WHERE id = " . $this->id);

        $this->load();
        return true;

    }

    function getPriserFromKursus()
    {
        $priser['ugeantal'] = $this->kursus->get('ugeantal');
        $priser['pris_uge'] = $this->kursus->get('pris_uge');
        $priser['pris_tilmeldingsgebyr'] = $this->kursus->get('pris_tilmeldingsgebyr');
        $priser['dato_start'] = $this->kursus->get('dato_start');
        $priser['dato_start_dk'] = $this->kursus->get('dato_start_dk');
        $priser['dato_start_dk_streng'] = $this->kursus->get('dato_start_dk_streng');
        $priser['dato_slut'] = $this->kursus->get('dato_slut');
        $priser['dato_slut_dk'] = $this->kursus->get('dato_slut_dk');
        $priser['dato_slut_dk_streng'] = $this->kursus->get('dato_slut_dk_streng');
        $priser['pris_materiale'] = $this->kursus->get('pris_materiale');
        $priser['pris_noegledepositum'] = $this->kursus->get('pris_noegledepositum');
        $priser['pris_rejsedepositum'] = $this->kursus->get('pris_rejsedepositum');
        $priser['pris_rejserest'] = (float)$this->kursus->get('pris_rejserest');
        $priser['pris_rejselinje'] = $this->kursus->get('pris_rejselinje');

        return $this->savePriser($priser);
    }

    function getList($show, $kursus_id = NULL)
    {
        $db = new DB_Sql;
        $i = 0;
        $tilmelding = array();
        $sql_limit = "";
        $sql_order = "adresse.fornavn";
        $sql = "";

        switch($show) {
            case "aktive":
                $sql = "(status_key >= 2) AND";
                break;

            case "inaktive":
                $sql = "(status_key < 2) AND";
                break;
            case 'nyeste': // fall through
            case "seneste":
                $sql = "status_key >= 2 AND";
                $sql_limit = "LIMIT 5";
                $sql_order = "date_created DESC";
                break;

            case "forfaldne":
                $sql = "faerdigbetalt = 0 AND (status_key >= 2 && status_key < 4 || status_key = -2) AND dato_start > '2006-06-31' AND" ;
                $sql_order = " dato_start ASC, adresse.fornavn ASC";
                break;
        }

        if ($kursus_id != NULL) {
            $sql .= " kursus_id = ".(int)$kursus_id." AND";
        }

        $sql = "SELECT tilmelding.* FROM langtkursus_tilmelding tilmelding
            LEFT JOIN adresse ON tilmelding.adresse_id = adresse.id
                WHERE ".$sql." active = 1 ORDER BY ".$sql_order." ".$sql_limit;
        $db->query($sql);
        $i = 0;
        while($db->nextRecord()) {
            $tilmelding[$i] = new VIH_Model_LangtKursus_Tilmelding($db->f('id'));
            $tilmelding[$i]->loadBetaling();
            $i++;

        }
        return $tilmelding;
    }

    function search($string)
    {
        $db = new DB_Sql;
        $db->query("SELECT DISTINCT(tilmelding.id) FROM langtkursus_tilmelding tilmelding
            INNER JOIN adresse ON adresse.id = tilmelding.adresse_id
            WHERE tilmelding.id='".$string."' OR adresse.fornavn LIKE '%".$string."%' OR adresse.efternavn LIKE '%".$string."%'");
        $list = array();
        $i = 0;
        while($db->nextRecord()) {
            $list[$i] = new VIH_Model_LangtKursus_Tilmelding($db->f('id'));
            $list[$i]->loadBetaling();
            $i++;
        }
        return $list;
    }

    ///////////////////////////////////////////////////////////////////////////////
    // Fag
    ///////////////////////////////////////////////////////////////////////////////

    /**
     *  Funktionen skal ikke slette fag, der skal blive.
     */
    function flushFag($fag_der_skal_blive = array())
    {
        $db = new DB_Sql;
        $db->query("DELETE FROM langtkursus_tilmelding_x_fag WHERE tilmelding_id = " . $this->id . " AND  fag_id != '".implode("' AND fag_id != '",$fag_der_skal_blive)."'");
        return true;
    }

    function addFag($fag, $periode = null)
    {
        $db = new DB_Sql;
        if (isset($periode) AND $periode->getId() > 0) {
            $db->query("SELECT id FROM langtkursus_tilmelding_x_fag
                WHERE tilmelding_id = " . $this->id . "
                    AND fag_id = " . (int)$fag->getId() . "
                    AND periode_id = " . $periode->getId());

        } else {
            $db->query("SELECT id FROM langtkursus_tilmelding_x_fag
                WHERE tilmelding_id = " . $this->id . "
                    AND fag_id = " . (int)$fag->getId());
        }
        if (!$db->nextRecord()) {
            if (isset($periode) AND $periode->getId() > 0) {
                $db->query("INSERT INTO langtkursus_tilmelding_x_fag
                    SET tilmelding_id = " . $this->id . ",
                        fag_id = " . (int)$fag->getId() . ", periode_id = " . $periode->getId());

            } else {

                $db->query("INSERT INTO langtkursus_tilmelding_x_fag
                    SET tilmelding_id = " . $this->id . ",
                        fag_id = " . (int)$fag->getId());
            }
        }
        return true;
    }

    function hasSelectedFag($fag, $periode)
    {
        $db = new DB_Sql;
        $db->query("SELECT * FROM langtkursus_tilmelding_x_fag
            WHERE tilmelding_id = " . $this->id . "
                AND fag_id = " . $fag->getId() . "
                AND periode_id = " . $periode->getId());
        return ($db->numRows() > 0);
    }

    function getFag()
    {
        /*
        $db1 = new DB_Sql;
        $db1->query("SELECT * FROM langtkursus_tilmelding_x_fag
            WHERE tilmelding_id = " . $this->id);
        $fag = array();
        while ($db1->nextRecord()) {
            $periode = VIH_Model_LangtKursus_Periode::getFromId($db, $db1->f('periode_id'));
            $f = new VIH_Model_Fag($db1->f('fag_id'));
            $fag[] = new VIH_Model_LangtKursus_FagPeriode($f, $periode);
        }
        return $fag;
        */
        $conn = Doctrine_Manager::connection(DB_DSN);
        $conn->setCharset('utf8');
        $registration = Doctrine::getTable('VIH_Model_Course_Registration')->findOneById($this->id);

        $chosen = array();
        foreach ($registration->Subjects as $subject) {
            $chosen[] = $subject;
        }
        return $chosen;
    }

    ///////////////////////////////////////////////////////////////////////////////
    // Betalinger
    ///////////////////////////////////////////////////////////////////////////////

    function setStatus($status)
    {
        if (empty($this->status)) {
            return false;
        }
        $status_key = array_search($status, $this->status);
        if ($status_key === false) {
            throw new Exception('Ugyldig status');
        }

        if ($this->id == 0) {
            return false;
        }

        $conn = Doctrine_Manager::connection(DB_DSN);
        $conn->setCharset('utf8');
        $registration = Doctrine::getTable('VIH_Model_Course_Registration')->findOneById($this->id);
        $registration->status_key = $status_key;
        $registration->save();

        $this->load();

        return true;
    }

    /**
     * Marker tilmelding som f�rdigbetalt hvis der ikke er noget skyldigt bel�b
     */
    public function _updateStatus()
    {
        $db = new DB_Sql;
        // hack hack hack hack
        if ($this->get('pris_total') > 0
                AND count($this->getRater()) > 0) {
            if (!$this->betaling_loaded) {
                $this->loadBetaling();
            }
        }

        if (count($this->getRater()) == 0) {
            return true;
        }

        if ($this->get("skyldig") <= 0  && $this->rateDifference() == 0) {
            $status_key = $this->getStatusKey('afsluttet');
        } elseif ($this->get("skyldig_tilmeldingsgebyr") <= 0) {
            $status_key = $this->getStatusKey('tilmeldt');
        } else {
            $status_key = $this->getStatusKey('reserveret');
        }

        $db->query("UPDATE langtkursus_tilmelding SET status_key=".$status_key." WHERE id = ".$this->id);


        $this->load();

        return true;
    }


    function loadBetaling() {

        if ($this->id == 0) {
            return false;
        }

        $this->betalingsobject = new VIH_Model_Betaling('langekurser', $this->id);
        $tmp = $this->betalingsobject->getList(); // loader total
        $this->value['betalt_not_approved'] = $this->betalingsobject->get('total_completed');
        $this->value['betalt'] = $this->betalingsobject->get('total_approved');
        $this->value['saldo'] = $this->get('pris_total') - $this->get('betalt');
        $this->value['skyldig_tilmeldingsgebyr'] = $this->get('pris_tilmeldingsgebyr') - $this->value['betalt'];
        $this->value['skyldig'] = $this->get('pris_total') - $this->get('betalt');

        $this->value['forfalden'] = 0; // denne b�r lige regnes ud

        $this->betaling_loaded = true;

        if (empty($this->value['pris_total']) OR $this->value['pris_total'] == 0 OR $this->antalRater() <= 1) {
            return true;
        }

        $this->_updateStatus();

        return true;
    }

    function getStatusKey($value)
    {
        return array_search($value, $this->status);
    }

    function betalingFactory()
    {
        return new VIH_Model_Betaling('langekurser', $this->id);
    }

    ///////////////////////////////////////////////////////////////////////////////
    // Rater
    ///////////////////////////////////////////////////////////////////////////////

    function antalRater()
    {
        $db = new DB_Sql;

        $db->query("SELECT COUNT(id) AS number FROM langtkursus_tilmelding_rate WHERE langtkursus_tilmelding_id = ".$this->id);
        $db->nextRecord();

        return $db->f("number");
    }

    function opretRater()
    {
        if ($this->antalRater() == 0) {
            $db = new DB_Sql;
            $db2 = new DB_Sql;

            $db->query("SELECT * FROM langtkursus_rate WHERE langtkursus_id = ".$this->get("kursus_id")." ORDER BY betalingsdato");
            //echo $db->numRows();

            while($db->nextRecord()) {
                $db2->query("INSERT INTO langtkursus_tilmelding_rate SET langtkursus_tilmelding_id = ".$this->id.", betalingsdato = \"".$db->f("betalingsdato")."\", beloeb = \"".$db->f("beloeb")."\"");
            }
        }

        return true;
    }

    function createRate($betalingsdato, $beloeb)
    {
        $db2 = new DB_Sql;
        $db2->query("INSERT INTO langtkursus_tilmelding_rate
            SET langtkursus_tilmelding_id = ".$this->id.",
                betalingsdato = \"".$betalingsdato."\",
                beloeb = \"".$beloeb."\"");
        return true;
    }

    function getRater()
    {
        $rate = array();
        $db = new DB_Sql;
        $i = 0;

        $db->query("SELECT *, DATE_FORMAT(betalingsdato, '%d-%m-%Y') AS dk_betalingsdato FROM langtkursus_tilmelding_rate WHERE langtkursus_tilmelding_id = ".$this->id." ORDER BY betalingsdato");

        while($db->nextRecord()) {
            //if ($db->f("beloeb") == 0) continue;
            $rate[$i]["id"] = $db->f("id");
            $rate[$i]["dk_betalingsdato"] = $db->f("dk_betalingsdato");
            $rate[$i]["betalingsdato"] = $db->f("betalingsdato");
            $rate[$i]["beloeb"] = $db->f("beloeb");

            $i++;
        }

        return $rate;
    }

    function updateRater($rater)
    {

        if (is_array($rater)) {
            $db = new DB_Sql;
            for ($i = 0, $max = count($rater); $i < $max; $i++) {
                $dato = new VIH_Date($rater[$i]["betalingsdato"]);
                if ($dato->convert2db()) {
                    $db->query("UPDATE langtkursus_tilmelding_rate SET betalingsdato = \"".$dato->get()."\", beloeb = \"".intval($rater[$i]["beloeb"])."\" WHERE id = ".intval($rater[$i]["id"])." AND langtkursus_tilmelding_id = ".$this->get("id"));
                }
            }
        }

        return true;
    }


    function addRate($number)
    {
        settype($number, "integer");
        $db = new DB_Sql;

        if ($number > 0) {

            $db->query("SELECT DATE_FORMAT(betalingsdato, '%d') AS d, DATE_FORMAT(betalingsdato, '%m') AS m, DATE_FORMAT(betalingsdato, '%Y') AS y
                FROM langtkursus_tilmelding_rate WHERE langtkursus_tilmelding_id = ".$this->id." ORDER BY betalingsdato DESC LIMIT 1");
            if ($db->nextRecord()) {
                $m = $db->f("m");
                $d = $db->f("d");
                $y = $db->f("y");
            } else {
                $m = date("m");
                $d = date("d");
                $y = date("y");
            }

            for ($i = 0; $i < $number; $i++) {
                $betalingsdato = date("Y-m-d", mktime(0, 0, 0, $m+$i+1, $d, $y));
                $db->query("INSERT INTO langtkursus_tilmelding_rate SET langtkursus_tilmelding_id = ".$this->id.", betalingsdato = \"".$betalingsdato."\"");
            }
        }

        if ($number < 0) {
            $number *= -1;
            $db->query("DELETE FROM langtkursus_tilmelding_rate WHERE langtkursus_tilmelding_id = ".$this->id." ORDER BY betalingsdato DESC LIMIT ". $number);
        }

        return 1;
    }

    function deleteRate($rate_id)
    {
        $db = new DB_Sql;
        $db->query("DELETE FROM langtkursus_tilmelding_rate WHERE id = " . $rate_id);
        return 1;
    }

    function rateDifference()
    {

        $db = new DB_Sql;
        $rate_samlet = $this->get("pris_tilmeldingsgebyr");

        $db->query("SELECT beloeb FROM langtkursus_tilmelding_rate WHERE langtkursus_tilmelding_id = ".$this->id);
        while($db->nextRecord()) {
            $rate_samlet += $db->f("beloeb");
        }
        return $rate_samlet - $this->get("pris_total");
    }
    /*
    function getBetalt($calculate = false) {
        die('skal skrives om');
        if ($calcutate == true || $this->betalt === false) {

            $betalt = 0;
            $historik = new TilmeldingHistorik($this);
            foreach ($historik->getList() AS $b) {
                $betalt += $b['betaling'];
            }
            return $betalt;
        }
        else {
            return $this->betalt;
        }
    }

    function getForfalden() {
        die('skal skrives om');
        $betalt = $this->getBetalt();
        $forfalden = 0;
        $rater_samlet = $this->kursus->get("depositum");

        if ($this->get("date_created") < date("Y-m-d", time() - (60 * 60 * 24 * 14))) { // 14 dage
            if ($rater_samlet > $betalt) {
                $forfalden += $rater_samlet - $betalt;
            }
        }

        $rater = $this->getRater();
        for ($i = 0, $max = count($rater); $i < $max; $i++) {
            $rater_samlet += $rater[$i]["beloeb"];
            if ($rater[$i]["betalingsdato"] < date("Y-m-d")) {
                if ($rater_samlet > $betalt) {
                    $forfalden += $rater_samlet - $betalt;
                }
            }
        }

        return $forfalden;
    }
    */

    /*
    function afbrydOphold($uger_deltaget, $beloeb_afskrevet) {

        $sql = "afbrudt_uger_deltaget = ".(int)$uger_deltaget.",
            ugeantal = ".(int)$uger_deltaget.",
            afbrudt_beloeb_afskrevet = ".(int)$beloeb_afskrevet.",
            status_key = -2";

        $db = new DB_sql;
        $db->query("UPDATE langtkursus_tilmelding SET ".$sql." WHERE id = ".$this->id);
        $this->load();

        return 1;
    }
    */


    ///////////////////////////////////////////////////////////////////////////////
    // Email
    ///////////////////////////////////////////////////////////////////////////////

    function sendEmail()
    {
        if (!$this->get('email')) return 0;
        $mail = new VIH_Email;
        $mail->setSubject('Tilmelding #' . $this->id);
        $mail->setBody('
Tak for din tilmelding. Du er registreret i vores system.

Du kan følge din tilmelding på:

'.LANGEKURSER_LOGIN_URI.$this->get('code').'

På denne side kan du printe kvitteringer ud og betale evt. skyldige beløb.
Vi glæder os til at møde dig!

--
Med venlig hilsen
En email-robot
Vejle Idrætshøjskole
');
        $mail->addAddress($this->get('email'), $this->get('navn'));
        return $mail->send();
    }

    /**
     * Bruges til at s�tte et session_id, hvis ordren ikke har noget, og brugeren
     * skal forts�tte sin bestilling.
     *
     * B�r meget sj�ldent bruges
     */

    ///////////////////////////////////////////////////////////////////////////////
    // Saerlige metoder
    ///////////////////////////////////////////////////////////////////////////////

    function setSessionId()
    {
        $db = new DB_Sql;
        $db->query("UPDATE langtkursus_tilmelding SET date_updated = NOW(), session_id = '".vih_random_code(28)."' WHERE id = '" . $this->id . "'");
        $this->load();
        return true;
    }

    function getWeeks()
    {
        $span = new Date_Span(new Date($this->get('dato_start')), new Date($this->get('dato_slut')));
        return round($span->toDays() / 7);
    }

    function getAge()
    {
        return (float)vih_calculate_age($this->get('birthday'), $this->get('dato_start'));
    }

    function isDanishCitizen()
    {
        return true;
    }

    function getStartDate()
    {

    }

    function getEndDate()
    {

    }

    function getId()
    {
        return $this->id;
    }
}
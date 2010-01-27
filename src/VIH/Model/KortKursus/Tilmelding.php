<?php
/**
 * PHP version 5
 *
 * @package VIH_Tilmelding
 * @author  Lars Olesen <lars@legestue.net>
 */
require_once 'VIH/functions.php';

define('TABLE_KORTKURSUS_TILMELDING_DELTAGER', 'kortkursus_deltager_ny');

class VIH_Model_KortKursus_Tilmelding
{
    protected $id;
    public $betaling;
    public $kursus;
    protected $value = array();
    public $status = array(
        -3 => 'venteliste',
        -2 => 'slettet', // hvis ordren slettes inde fra systemet
        -1 => 'annulleret', // hvis man annullerer under tilmeldingsproceduren eller fra systemet
        0  => 'ikke tilmeldt', // standardinstillingen
        1  => 'undervejs', // når man er i gang med selv tilmeldingen
        2  => 'reserveret', // når man har trykket confirm under tilmeldingen
        3  => 'tilmeldt', // når man har betalt tilmeldingsgbyret
        4  => 'afsluttet' // når man har betalt hele beløbet
    );

    function __construct($id = 0)
    {
        $this->id = (int)$id;

        $this->value['betalt']              = 'ikke loadet';
        $this->value['betalt_not_approved'] = 'ikke loadet';
        $this->value['saldo']               = 'ikke loadet';
        $this->value['skyldig_depositum']   = 'ikke loadet';
        $this->value['skyldig']             = 'ikke loadet';

        if ($this->id > 0) {
            $this->load();
        }
    }

    /**
     * Returnerer værdier
     */
    function get($key = '')
    {
        if (!empty($key)) {
            if (!empty($this->value[$key])) {
                return $this->value[$key];
            }
            return '';
        }
        return $this->value;
    }

    /**
     * Loader værdier
     */
    function load()
    {
        if ($this->id == 0) {
            return 0;
        }

        $sql = "SELECT code, tilmelding.id, tilmelding.active, adresse_id, besked, kortkursus_id, session_id, antal_deltagere, status_key, afbestillingsforsikring, rabat, DATE_FORMAT(tilmelding.date_created, '%d-%m-%Y') AS date_created_dk,
            date_add(tilmelding.date_created, interval 10 day) AS dato_forfalden_depositum,
           DATE_FORMAT(date_add(tilmelding.date_created, interval 10 day), '%d-%m-%Y') AS dato_forfalden_depositum_dk,
            date_sub(kortkursus.dato_start, interval 42 day) AS dato_forfalden,
              DATE_FORMAT(date_sub(kortkursus.dato_start, interval 42 day), '%d-%m-%Y') AS dato_forfalden_dk
            FROM kortkursus_tilmelding tilmelding
            INNER JOIN kortkursus
                ON kortkursus.id = tilmelding.kortkursus_id
            WHERE tilmelding.id = " . $this->id;
        $db = new DB_Sql;
        $db->query($sql);

        if (!$db->nextRecord()) {
            return 0;
        }

        $this->kursus = new VIH_Model_KortKursus($db->f('kortkursus_id'));
        $this->id = $db->f('id');
        $this->value['id'] = $db->f('id');
        $this->value['kursusnavn'] = $this->kursus->get('kursusnavn');
        $this->value['date_created_dk'] = $db->f('date_created_dk');
        $this->value['code'] = $db->f('code');
        $this->value['dato_forfalden_depositum'] = $db->f('dato_forfalden_depositum');
        $this->value['dato_forfalden_depositum_dk'] = $db->f('dato_forfalden_depositum_dk');
        $this->value['dato_forfalden'] = $db->f('dato_forfalden');
        $this->value['dato_forfalden_dk'] = $db->f('dato_forfalden_dk');
        if ($this->value['dato_forfalden'] < date('Y-d-m')) {
            $nextweek = mktime(0, 0, 0, date("m")  , date("d")+7, date("Y"));
            $this->value['date_forfalden'] = date('Y-m-d', $nextweek);
            $this->value['date_forfalden_dk'] = date('d-m-Y', $nextweek);
        }

        if ($db->f('adresse_id') > 0) {
            $adresse = new VIH_Model_Adresse($db->f('adresse_id'));
            $this->value['adresse_id'] = $adresse->get('id');
            $this->value['navn'] = $adresse->get('navn');
            $this->value['fornavn'] = $adresse->get('fornavn');
            $this->value['efternavn'] = $adresse->get('efternavn');
            $this->value['adresse'] = $adresse->get('adresse');
            $this->value['postnr'] = $adresse->get('postnr');
            $this->value['postby'] = $adresse->get('postby');
            $this->value['telefonnummer'] = $adresse->get('telefon');
            $this->value['arbejdstelefon'] = $adresse->get('arbejdstelefon');
            $this->value['mobil'] = $adresse->get('mobil');
            $this->value['email'] = $adresse->get('email');
        }

        $this->value['besked'] = $db->f('besked');
        $this->value['kursus_id'] = $db->f('kortkursus_id');
        $this->value['session_id'] = $db->f('session_id');
        $this->value['status'] = $this->status[$db->f('status_key')];
        $this->value['status_key'] = $db->f('status_key');
        $this->value['afbestillingsforsikring'] = $db->f('afbestillingsforsikring');
        if ($this->value['afbestillingsforsikring'] == 'Ja') {
            $this->value['pris_afbestillingsforsikring'] = $this->kursus->get('pris_afbestillingsforsikring');
        }
        $this->value['antal_deltagere'] = $db->f('antal_deltagere');
        $this->value['rabat'] = $db->f('rabat');
        $this->value['active'] = $db->f('active');

        $keywords[] = 'ingen';

        if ($this->kursus->get('gruppe_id') == 1) {
            $keywords[] = 'golf';
        }
        if ($this->kursus->get("gruppe_id") == 3) {
            $keywords[] = 'bridge';
        }
        if ($this->kursus->get("gruppe_id") == 5) {
            $keywords[] = 'camp';
        }

        $this->value['keywords'] = $keywords;

        // ekstra oplysninger
        $oplysning = new VIH_Model_KortKursus_Tilmelding_TilmeldingOplysning($this);
        $this->value['hvilkettidligerekursus'] = $oplysning->get('hvilkettidligerekursus');

        return $this->id = $db->f('id');
    }


    /**
     * Bruges til at slette tilmeldinger
     *
     * Tilmeldinger må aldrig slettes helt fra databasen, men skal bare deaktiveres.
     *
     * @todo 22. maj: Der har været et enkelt tilfælde, hvor en masse poster er kommet tilbage
     *                - det er mystisk.
     *
     * @return 1 on success
     */
    function delete()
    {
        if ($this->id == 0) {
            return false;
        }
        $db = new DB_Sql;
        $db->query("UPDATE kortkursus_tilmelding SET date_updated= NOW(), active = 0, status_key = ".$this->getStatusKey('slettet')." WHERE id = " . $this->id);

        $this->load();
        $this->_updateStatus();

        return true;
    }

    function validate($var)
    {
        $validate = new Validate;

        return true;
    }

    /**
     * Bruges til at opdatere ordren
     *
     * @return inserted id on success
     */
    function save($var)
    {
        $var['navn'] =	$var['kontaktnavn'];
        settype($var['rabat'], 'string');

        if (!$this->validate($var)) {
            return 0;
        }

        // Adresse gemmes
        $adresse = new VIH_Model_Adresse((int)$this->get('adresse_id'));
        $adresse_id = $adresse->save($var);

        // her laves sql-typerne
        if ($this->id > 0) {
            $sql_type = "UPDATE ";
            $sql_end = " WHERE id = " . $this->id;
        } else {
            throw new Exception('Der kan kun oprettes ordrer fra OnlineTilmelding');
        }

        $db = new DB_Sql;

        $sql = $sql_type . "kortkursus_tilmelding
            SET
                date_updated = NOW(),
                adresse_id = ".$adresse_id.",
                besked = '".$var['besked']."',
                afbestillingsforsikring = '".$var['afbestillingsforsikring']."',
                rabat = '".$var['rabat']."'
            " . $sql_end;


        $db->query($sql);

        if ($this->id == 0) {
            $this->id = $db->insertedId();
        }

        // ekstra oplysninger
        if (!empty($var['hvilkettidligerekursus'])) {
            $oplysning = new VIH_Model_KortKursus_Tilmelding_TilmeldingOplysning($this);
            $oplysning->save('hvilkettidligerekursus', $var['hvilkettidligerekursus']);
        }

        $this->load();

        return $this->id;
    }

    function setCode()
    {
        // @todo bør tjekkes endnu en gang
        $db = new DB_Sql;
        $random_code = vih_random_code(12);
        $db->query("SELECT * FROM kortkursus_tilmelding WHERE code = '".$random_code."'");
        if ($db->numRows() > 0) {
            $random_code = vih_random_code(12);
        }
        $db->query("UPDATE kortkursus_tilmelding SET code = '".$random_code."' WHERE id = " . $this->id);

        $this->load();
        return true;
    }

    /**
     * Denne metode skal opdatere status alt efter hvor meget der er betalt
     * Køres fra loadBetaling(). Må ikke køres andre steder fra.
     *
     * @private but is kept public for testing purposes
     */
    public function _updateStatus()
    {
        $db = new DB_Sql;
        if (!$this->get('antal_deltagere') && $this->get('skyldig') <= 0 && $this->get('status') == 'afsluttet') {
            return true; // vi lader som om at alt gik godt
        }

        if ($this->get('active') == 0) {
            $status = $this->getStatusKey('slettet');
        } elseif ($this->get('skyldig') <= 0) {
            $status = $this->getStatusKey('afsluttet');
        } elseif ($this->get('skyldig_depositum') <= 0) {
            $status = $this->getStatusKey('tilmeldt');
        } elseif ($this->get('skyldig_depositum') > 0) {
            $status = $this->getStatusKey('reserveret');
        } elseif ($this->get('skyldig') > 0) {
            $status = $this->getStatusKey('tilmeldt');
        } else {
            // skal ikke opdatere status, hvis den ikke er under.
            return true;
        }

        $db->query("UPDATE kortkursus_tilmelding SET date_updated = NOW(), status_key = ".$status." WHERE id = ".$this->id);

        $this->value['status'] = $this->status[$status];

        //$this->load();

        return true;
    }

    function setStatus($status)
    {
        $status_key = array_search($status, $this->status);
        if ($status_key === false) {
            trigger_error("Ugyldig status");
        }

        if ($this->id == 0) {
            return false;
        }

        $db = new DB_Sql;
        $db->query("UPDATE kortkursus_tilmelding SET status_key = ".$status_key.", date_updated = NOW() WHERE id = ".$this->id);

        $this->value['status'] = $status;

        //$this->load();

        return true;
    }

    function getStatusKey($string)
    {
        return array_search($string, $this->status);
    }

    function getStatus()
    {
        return $this->value['status'];
    }

    function getKursus()
    {
        return new VIH_Model_KortKursus($this->get('kursus_id'));
    }

    /**
     * Funktion til at hente alle deltagerne
     */
    public function getDeltagere()
    {
        // bør sørge for at der er en ordre loadet
        if (!$this->id) {
            trigger_error('Tilmelding::getDeltagere(): Der er ikke loadet noget ordre');
        }

        $db = new DB_Sql;
        $sql = "SELECT id
            FROM kortkursus_deltager_ny deltager
            WHERE tilmelding_id = " . $this->id . "
                AND deltager.active = 1";
        $db->query($sql);

        $deltagere = array();
        while ($db->nextRecord()) {
            $deltagere[] = new VIH_Model_KortKursus_Tilmelding_Deltager($this, $db->f('id'));
        }

        return $deltagere;
    }

    // ANGÅENDE PRISER OG BETALING

    /**
     * skal finde ud af om, der er bestilt afbestillingsforsikring?
     * skal så loope gennem deltagerne og lægge deres priser sammen!
     *
     * @return	$pris['total']	(float)	pris inklusiv det hele
     * 					$pris['kursuspris']	(float)	pris kun for selve kurset
     * 					$pris['depositum']	(float)	pris kun for depositum
     * 					$pris['forudbetaling']	(float)	pris som skal betales forud
     * 					$pris['forsikring']	(float)	pris for forsikring
     */
    function loadPris()
    {
        $this->value['pris_total'] = 0;
        $this->value['pris_kursuspris'] = 0;
        $this->value['pris_depositum'] = 0;
        $this->value['pris_forudbetaling'] = 0;
        $this->value['pris_forsikring'] = 0;

        foreach ($this->getDeltagere() as $deltager) {
            $indkvartering = $deltager->getIndkvartering();
            $this->value['pris_kursuspris'] += $deltager->get('pris') + $indkvartering['price'];
            $this->value['pris_depositum'] += $this->kursus->get('pris_depositum');
            $this->value['pris_forsikring'] += $this->get('pris_afbestillingsforsikring');
        }
        $this->value['pris_forudbetaling'] += $this->value['pris_forsikring'] + $this->value['pris_depositum'];
        $this->value['rabat'] = (float)$this->get('rabat');
        $this->value['pris_total'] += $this->value['pris_kursuspris'] + $this->value['pris_forsikring'];
        $this->value['pris_total'] -= (float)$this->get('rabat');
        return true;
    }

    /**
     * Denne funktion skal loade kundens betalinger.
     *
     * Funktionen skelner mellem godkendte betalinger hos PBS, men som stadig
     * afventer at blive trukket og betalinger, som er godkendte (captured).
     */
    function loadBetaling()
    {
        if ($this->id == 0) {
            return false;
        }

        if (empty($this->value['pris_total'])) {
            $this->loadPris();
        }

        $this->betaling = new VIH_Model_Betaling('kortekurser', $this->id);
        $tmp = $this->betaling->getList(); // loader total

        $this->value['betalt'] = (float)$this->betaling->get('total_approved');
        $this->value['betalt_not_approved'] = (float)$this->betaling->get('total_completed');
        $this->value['saldo'] = (float)$this->value['pris_total'] - $this->value['betalt'];
        $this->value['skyldig_depositum'] = (float)$this->value['pris_forudbetaling'] - $this->value['betalt'];
        $this->value['skyldig'] = (int)$this->value['saldo'];

        $this->value['forfalden'] = 0;
        if ($this->get('dato_forfalden_depositum') < date('Y-m-d H:i:s') AND $this->get('skyldig_depositum') > 0) { // skyldig forfalden depositum
            $this->value['forfalden_depositum'] = (float)$this->value['skyldig_depositum'];
            $this->value['forfalden'] = (float)$this->value['skyldig_depositum'];
        }

        if ($this->get('dato_forfalden') < date('Y-m-d') AND $this->get('skyldig') > 0) { // skyldig forfalden
            $this->value['forfalden'] = (float)$this->value['skyldig'];
        }

        // opdaterer status for tilmeldingen
        if (!$this->_updateStatus()) {
            trigger_error('Kunne ikke opdatere status for tilmeldingen', E_USER_ERROR);
        }

        return true;
    }

    /**
     *
     */
    function getForfaldenDato($key = '', $sprog = '')
    {
        if (!in_array($key, array('depositum', ''))) {
            die("Tilmelding->getForfaldenDato");
        }
        if (!empty($sprog)) {
            $sprog = '_'. $sprog;
        }

        $db = new DB_Sql;

        switch ($key) {
            case 'depositum':
                $db->query("SELECT
                        date_add(date_created, interval 10 day) AS dato_forfalden,
           DATE_FORMAT(date_add(date_created, interval 10 day), '%d-%m-%Y') AS forfald_dk
       FROM kortkursus_tilmelding
       WHERE id=".$this->get('id'));
                break;

            default:
                $db->query("SELECT date_sub(dato_start, interval 42 day) AS dato_forfalden,
              DATE_FORMAT(date_sub(dato_start, interval 42 day), '%d-%m-%Y') AS forfald_dk
       FROM kortkursus
       WHERE id=".$this->kursus->get('id'));
                break;
        }

        if (!$db->nextRecord()) {
            return 0;
        }
        return $db->f('forfald'. $sprog);
    }

    /**
     *
     */
    function getForfalden($key = '')
    {
        if (!in_array($key, array('depositum', ''))) {
            die("Tilmelding->getForfalden");
        }
        // date('Y-m-d')

        if ($key == "depositum") {
            $skyldig = "skyldig_depositum";
        } else {
            $skyldig = "skyldig";
        }

        if ($this->getForfaldenDato($key) < date('Y-m-d') AND $this->get($skyldig) > 0) {
            return 1;
        }
        return 0;
    }

    // DIVERSE METODER

    /**
     * Regler:
     * - Personer over 2 år udløser en seng
     * - Flere end tre personer på en tilmelding udløser en seng
     * @see	Kortkursus
     * @deprecated
     */
    function getVaerelser()
    {
        return $this->getRoomsNeeded();
    }


    /**
     * Regler:
     * - Personer over 2 år udløser en seng
     * - Flere end tre personer på en tilmelding udløser en seng
     * @see	Kortkursus
     * @deprecated
     */
    function getRoomsNeeded()
    {
        $vaerelser = 0;
        $person = 0;
        foreach ($this->getDeltagere() AS $d) {
            $deltager = new VIH_Model_KortKursus_Tilmelding_Deltager($this, $d['id']);
            if ($deltager->calculateAge($deltager->get('birthday'), $this->kursus->get('startdato')) > 2) {
                $person++;
            }
        }
        return ceil($person / 2);
    }


    /**
     * Bruges til at konfirmere e-mail-adressen efter der er sendt e-mail til dem
     */
    function setKontaktMedEmail($kode)
    {
        die('Bruges ikke');
        if (is_object($this->kursus)) {
            if ($kode == $this->kursus->get('id')) {
                $db = new DB_Sql;
                $db->query("UPDATE kortkursus_tilmelding SET emailkontakt = 'Ja' WHERE id = " . $this->id);
            }
        } else {
            trigger_error("Det er ikke pænt, at du forsøger at snyde med vores e-mail-bekræftelse.", E_USER_ERROR);
        }
    }

    function getLastModified()
    {
        $db = new DB_Sql;
        $db->query("SELECT dato AS date_updated FROM kortkursus_tilmelding WHERE active = 1 AND status_key = 0 ORDER BY date_updated DESC LIMIT 1");
        if (!$db->nextRecord()) {
            return 0;
        }
        return $db->f("date_updated");
    }

    function sendEmail()
    {
        if (!$this->get('email')) return 0;
        $mail = new VIH_Email;
        $mail->setSubject('Tilmelding #' . $this->id);
        $mail->setBody('
Tak for din tilmelding. Du er registreret i vores system, og kan følge din tilmelding på:

'.KORTEKURSER_LOGIN_URI.$this->get('code').'

På denne side kan du printe kvitteringer ud og betale evt. skyldige beløb.
Vi glæder os til at møde dig!

--
Med venlig hilsen
En email-robot
Vejle Idrætshøjskole
');


        $mail->addAddress($this->get('email'), $this->get('navn'));

        return $return = $mail->send();
    }


    function getId()
    {
        return $this->id;
    }

    /**
     *
     * status_key 2 = reserveret; 3 = tilmeldt
     */
    function getList($type = '', $limit = 5)
    {
        $gateway = new VIH_Model_KortKursus_TilmeldingGateway;
        if (!empty($type)) {
            return $gateway->findByType($type, $limit);
        } else {
            return $gateway->findAll($limit);
        }
        /*
        switch ($type) {
            case 'restance': // fall through
                $type = 'forfaldne';
            case 'forfaldne':
                $sql = "SELECT distinct tilmelding.id FROM kortkursus_tilmelding tilmelding
                    WHERE (status_key = 2
                        OR status_key = 3) AND active = 1
                    ORDER BY date_created ASC LIMIT " . $limit;
                break;
            default:
                $sql = "SELECT distinct tilmelding.id FROM kortkursus_tilmelding tilmelding
                    WHERE (status_key >= 2
                        AND status_key <= 4) AND active = 1
                    ORDER BY id DESC LIMIT " . $limit;
                break;
        }

        $db = new DB_Sql;
        $db->query($sql);

        $tilmeldinger = array();

        $i = 0;
        while ($db->nextRecord()) {
            $tilmeldinger[$i] = new VIH_Model_KortKursus_Tilmelding($db->f('id'));
            $tilmeldinger[$i]->loadBetaling();
            $i++;
        }

        return $tilmeldinger;
        */
    }

    function search($string)
    {
        $gateway = new VIH_Model_KortKursus_TilmeldingGateway;
        return $gateway->findByString($string);
        /*
        $db = new DB_Sql;
        $db->query("SELECT DISTINCT(tilmelding.id) FROM kortkursus_tilmelding tilmelding
            INNER JOIN adresse ON adresse.id = tilmelding.adresse_id
            WHERE tilmelding.id='".$string."' OR adresse.fornavn LIKE '%".$string."%' OR adresse.efternavn LIKE '%".$string."%'");
        $list = array();
        $i = 0;
        while ($db->nextRecord()) {
            $list[$i] = new VIH_Model_KortKursus_Tilmelding($db->f('id'));
            $list[$i]->loadBetaling();
            $i++;
        }
        return $list;
    	*/
    }


    public static function factory($handle)
    {
        $gateway = new VIH_Model_KortKursus_TilmeldingGateway();
        return $gateway->findByHandle($handle);
        /*
        $handle = mysql_escape_string($handle);
        $handle = strip_tags($handle);
        $handle = trim($handle);

        if (empty($handle)) {
            return false;
        }

        $db = new DB_Sql;
        $db->query("SELECT id FROM kortkursus_tilmelding WHERE code='".$handle."'");
        if ($db->numRows() == 1 AND $db->nextRecord()) {
            return new VIH_Model_KortKursus_Tilmelding($db->f('id'));
        }
        return false;
        */
    }
}
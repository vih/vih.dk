<?php
/**
 * Et langt kursus
 *
 * @package VIH
 * @author  Lars Olesen <lars@legestue.net>
 */
class VIH_Model_LangtKursus
{
    protected $id;
    protected $values;
    protected $underviser;
    protected $standardpriser = array('tilmeldingsgebyr' => 1000);
    protected $year;

    /**
     * Constructor
     *
     * @param mixed $id Either identifier or id
     */
    public function __construct($id = 0)
    {
        if (is_numeric($id)) {
            $this->id = (int)$id;
        } elseif (is_string($id) AND $id != 'allround') {
            $string = $id;
            $db = new DB_Sql();
            $db->query("SELECT id FROM langtkursus WHERE shorturl = '" . $string . "' AND dato_start > NOW() AND published = 1 AND active = 1 ORDER BY dato_start ASC LIMIT 1");

            if ($db->nextRecord()) {
                $this->id = (int)$db->f('id');
            } else {
                $this->id = 0;
            }
        } elseif (is_string($id) AND $id == 'allround') {
            $db = new DB_Sql();
            $db->query("SELECT id FROM langtkursus WHERE soegestreng = '' AND dato_start > NOW() AND published = 1 AND active = 1 ORDER BY id ASC LIMIT 1");
            if ($db->nextRecord()) {
                $this->id = (int)$db->f('id');
            } else {
                $this->id = 0;
            }
        } else {
            $this->id = 0;
        }

        if ($this->id > 0) {
            $this->load();
        }
    }

    public function getKursusNavn()
    {
        return $this->get('navn') . ' (' . $this->get('ugeantal') . ' uger), ' . $this->getYear();
    }

    function getTotalPrice()
    {
        return $this->get("pris_tilmeldingsgebyr") + ($this->get("ugeantal") * $this->get("pris_uge")) + $this->get("pris_materiale") + $this->get("pris_rejsedepositum") + $this->get("pris_rejselinje") + $this->get("pris_noegledepositum") + $this->get("pris_rejserest");
    }

    function getDateUpdatedRfc822()
    {
        return strftime("%a, %d %b %Y %H:%I:%S %z", strtotime($this->get("date_updated")));
    }

    function getDateStart()
    {
        return new Date($this->get('dato_start'));
    }

    function getDateEnd()
    {
        return new Date($this->get('dato_slut'));
    }

    function getYear()
    {
        return $this->year;
    }

    function getIdentifier()
    {
    	if (!empty($this->values['shorturl'])) {
    		return $this->values['shorturl'];
    	} else {
    		return $this->id;
    	}
    }

    private function load() {
        $sql = "SELECT *,
                DATE_FORMAT(dato_start, '%d-%m-%Y') AS dato_start_dk,
                DATE_FORMAT(dato_slut, '%d-%m-%Y') AS dato_slut_dk,
                DATE_FORMAT(dato_start, '%Y') AS aar
            FROM langtkursus
            WHERE id= ".$this->id . "
            ORDER BY dato_start DESC";

        $db = new DB_Sql;
        $db->query($sql);
        if (!$db->nextRecord()) {
            return false;
        }

        $this->values['id'] = $db->f('id');
        $this->values['shorturl'] = $db->f('shorturl');
        if (empty($this->values['shorturl'])) {
            $this->values['shorturl'] = $db->f('soegestreng');
        }

        $this->year = $db->f('aar');

        $this->values['navn'] = $db->f('navn');

        $this->values['title'] = $db->f('title');
        $this->values['description'] = $db->f('description');
        $this->values['keywords'] = $db->f('keywords');

        $this->values['dato_start'] = $db->f('dato_start');
        $this->values['dato_slut'] = $db->f('dato_slut');

        $this->values['ugeantal'] = $db->f('ugeantal');
        $this->values['beskrivelse'] = $db->f('beskrivelse');
        if (empty($this->values['beskrivelse'])) {
            $this->values['beskrivelse'] = $db->f('lang_beskrivelse');
        }
        $this->values['pris_uge'] = $db->f('pris_uge');
        $this->values['pris_materiale'] = $db->f('pris_materiale');
        $this->values['pris_rejsedepositum'] = $db->f('pris_rejsedepositum');
        $this->values['pris_rejserest'] = $db->f('pris_rejserest');
        $this->values['pris_rejselinje'] = $db->f('pris_rejselinje');
        $this->values['pris_noegledepositum'] = $db->f('pris_noegledepositum');

        $this->values['pris_tilmeldingsgebyr'] = $db->f('pris_tilmeldingsgebyr');
        if ($this->values['pris_tilmeldingsgebyr'] == 0) {
            //$this->values['pris_tilmeldingsgebyr'] = $db->f('depositum');
            if ($this->values['pris_tilmeldingsgebyr'] == 0) {
                $this->values['pris_tilmeldingsgebyr'] = $this->standardpriser['tilmeldingsgebyr'];
            }
        }

        $this->values['belong_to_id'] = $db->f('belong_to_id');
        $this->values['ansat_id'] = $db->f('ansat_id');
        if ($this->values['ansat_id'] == 0) {
            $this->values['ansat_id'] = $db->f('underviser_id');
        }

        $this->values['published'] = $db->f('published');
        $this->values['tekst_diplom'] = $db->f('tekst_diplom');

        return true;
    }

    public function get($key = '')
    {
        if (!empty($key)) {
            if (!empty($this->values[$key])) return $this->values[$key];
            else return '';
            //return $this->values[$key];
        }
        return $this->values;
    }

    private function validate($var)
    {
        return true;
    }

    public function save($var)
    {
        $fag = array();
        if (isset($var['fag'])) {
            $fag = $var['fag'];
            unset($var['fag']);
        }
        $var = array_map('trim', $var);
        $var = array_map('mysql_escape_string', $var);

        if (!$this->validate($var)) {
            return false;
        }

        if ($this->id == 0) {
            $sql_type = "INSERT INTO ";
            $sql_end = ", date_created = NOW()";
        } else {
            $sql_type = "UPDATE ";
            $sql_end = " WHERE id = " . $this->id;
        }

        $save = array('date_updated = NOW()');

        foreach ($var as $key => $value) {
            $save[] = $key . " = '".$value."'";
        }

        //belong_to = '".$var["belong_to"]."',
        $sql = $sql_type . "langtkursus
            SET " . implode(',', $save) . $sql_end;

        $db = new DB_Sql();
        $db->query($sql);

        if (empty($this->id)) {
            $this->id = $db->insertedId();
        }

        $this->load();

        return $this->id;
    }

    public function copy()
    {
        $value = $this->get();
        $value['navn'] = $this->get('navn') . '(kopi)';
        $fag = array();
        unset($value['id']);

        $new_kursus = new VIH_Model_LangtKursus();

        foreach ($this->getFag() AS $f) {
            $fag[] = $f->get('id');
        }

        $new_id =  $new_kursus->save($value);

        $new_kursus->addFag($fag);

        return $new_id;
    }

    public function delete()
    {
        if ($this->id == 0) {
            return false;
        }

        $db = new DB_Sql;
        $db->query("UPDATE langtkursus SET date_updated = NOW(), active = 0 WHERE id = " . $this->id);

        return true;
    }

    public function getList($show = "open")
    {
        $sql_ekstra = "";

        switch($show) {
            case 'åbne': // fall through
            case 'open':
                $sql_ekstra = "published = 1 AND DATE_ADD(dato_start, INTERVAL 14 DAY) > NOW()";
                break;
            case 'aktuelle':
                $sql_ekstra = "dato_slut > NOW()";
                break;
            case 'intranet':
                $sql_ekstra = "dato_slut > DATE_SUB(NOW(), INTERVAL 400 DAY)";
                break;
            default:
                $sql_ekstra = " 1 = 1";
                break;
        }

        $db = new DB_Sql;
        $db->query("SELECT id FROM langtkursus WHERE ".$sql_ekstra." AND active = 1 ORDER BY dato_start ASC, dato_slut DESC, belong_to ASC, navn ASC");
        $kurser = array();

        while ($db->nextRecord()) {
            $kurser[] = new VIH_Model_LangtKursus($db->f('id'));

        }

        return $kurser;
    }

    /**
     * Gets the next course
     *
     * @return object
     */
    public static function getNext()
    {
        $db = new DB_Sql;
        $db->query("SELECT id FROM langtkursus WHERE dato_start > NOW() AND published = 1 AND active = 1 ORDER BY dato_start ASC LIMIT 2");

        $courses = array();
        while ($db->nextRecord()) {
            $courses[] = new VIH_Model_LangtKursus($db->f('id'));
        }
        return $courses;
    }

    //////////////////////////////////////////////////////////////////////////////
    // FAG
    //////////////////////////////////////////////////////////////////////////////

    public function flushFag()
    {
        $db1 = new DB_Sql();
        $db1->query("DELETE FROM langtkursus_x_fag WHERE langtkursus_id = " . $this->id);
        return true;
    }


    /**
     * Sp�rgsm�let er om hvor et kursus oftest vil starte. Har man p� et kursus flere
     * perioder, hvor man har nogle forskellige faggruper i hver periode? - eller
     * har man forskellige faggruper, som man kan v�lge i forskellige perioder.
     */
    public function addFaggruppe($faggruppe)
    {

    }

    /**
     * @param object $fag     $fag
     * @param object $periode $periode
     *
     * @return boolean
     */
    public function addFag($fagperiode)
    {
        $db = new DB_Sql;

        if (!$fagperiode->hasPeriode()) {
            $sql = "INSERT INTO langtkursus_x_fag (fag_id, langtkursus_id) VALUES (" . $fagperiode->getFag()->getId().", " . $this->id . ")";
        } else {
            $sql = "INSERT INTO langtkursus_x_fag (fag_id, langtkursus_id, periode_id) VALUES (" . $fagperiode->getFag()->getId().", " . $this->id . ", ". $fagperiode->getPeriode()->getId(). ")";
        }
        $db->query($sql);
        return true;
    }

    public function getFag(pdoext_Connection $db, $type = 'published')
    {
        $sql = "SELECT IFNULL(langtkursus_fag_periode.date_start, '9999-01-01') AS date_start,
                IFNULL(langtkursus_fag_periode.date_end, '9999-01-01') AS date_end, fag.id AS id, x.periode_id as periode_id
            FROM langtkursus_x_fag x
            LEFT JOIN langtkursus_fag_periode ON x.periode_id = langtkursus_fag_periode.id
            INNER JOIN langtkursus_fag fag ON x.fag_id = fag.id
            INNER JOIN langtkursus_fag_gruppe gruppe ON fag.fag_gruppe_id = gruppe.id";

        if ($type == 'published') {
            $sql .= "
                INNER JOIN ansat_x_fag ON ansat_x_fag.fag_id = fag.id
                INNER JOIN ansat ON ansat.id = ansat_x_fag.ansat_id";
        }

        $sql .=	"	WHERE x.langtkursus_id = " . $this->id;
        if ($type == 'published') {
                    $sql .= " AND fag.active = 1 AND fag.published = 1";
        }
        $sql .= " ORDER BY
                           date_start ASC,
                           date_end DESC,
                           gruppe.position ASC,
                           fag.fag_gruppe_id ASC,
                           fag.navn ASC";

        $db1 = new DB_Sql();
        $db1->query($sql);
        $fag = array();
        while ($db1->nextRecord()) {
            $periode = VIH_Model_LangtKursus_Periode::getFromId($db, $db1->f('periode_id'));
            $fagperiode = new VIH_Model_LangtKursus_FagPeriode(new VIH_Model_Fag($db1->f('id')), $periode);
            // @todo may never use fag id as key, as it will make it impossible to have more than
            //       one course pr. period.
            $fag[] = $fagperiode;
        }
        return $fag;
    }

    function getFagToChooseFrom(pdoext_Connection $db, $type = 'published')
    {
        $sql = "SELECT fag.id AS id, IFNULL(langtkursus_fag_periode.date_start, '9999-01-01') AS date_start,
                IFNULL(langtkursus_fag_periode.date_end, '9999-01-01') AS date_end, x.periode_id as periode_id
            FROM langtkursus_x_fag x
            INNER JOIN langtkursus_fag_periode ON x.periode_id = langtkursus_fag_periode.id
            INNER JOIN langtkursus_fag fag ON x.fag_id = fag.id
            INNER JOIN langtkursus_fag_gruppe gruppe ON fag.fag_gruppe_id = gruppe.id";

        if ($type == 'published') {
            $sql .= "
                INNER JOIN ansat_x_fag ON ansat_x_fag.fag_id = fag.id
                INNER JOIN ansat ON ansat.id = ansat_x_fag.ansat_id";
        }

        $sql .= "   WHERE (gruppe.id = 1 OR gruppe.id = 2 OR gruppe.id = 15) AND fag.active = 1 AND x.langtkursus_id = " . $this->id;
        if ($type == 'published') {
                    $sql .= " AND fag.published = 1";
        }
        $sql .= " ORDER BY
                           date_start ASC,
                           date_end DESC,
                           gruppe.position ASC,
                           fag.fag_gruppe_id ASC,
                           fag.navn ASC";

        $db1 = new DB_Sql();
        $db1->query($sql);
        $fag = array();
        while ($db1->nextRecord()) {
            $periode = VIH_Model_LangtKursus_Periode::getFromId($db, $db1->f('periode_id'));
            $fagperiode = new VIH_Model_LangtKursus_FagPeriode(new VIH_Model_Fag($db1->f('id')), $periode);
            // @todo may never use fag id as key, as it will make it impossible to have more than
            //       one course pr. period.
            $fag[] = $fagperiode;
        }
        return $fag;
    }

    //////////////////////////////////////////////////////////////////////////////
    // TILMELDINGER
    //////////////////////////////////////////////////////////////////////////////

    public function getTilmeldinger()
    {
        $db = new DB_Sql;
        $db->query("SELECT id FROM langtkursus_tilmelding
            WHERE kursus_id = " . $this->id . "
            AND active = 1");
        $list = array();
        while($db->nextRecord()) {
            $list[$db->f('id')] = new VIH_Model_LangtKursus_Tilmelding($db->f('id'));
            $list[$db->f('id')]->loadBetaling();
        }
        return $list;
    }

    function getAntalTilmeldinger()
    {
        $db = new DB_Sql;
        $db->query("SELECT id FROM langtkursus_tilmelding
            WHERE kursus_id = " . $this->id . "
            AND active = 1");
        $list = array();
        while($db->nextRecord()) {
            $list[$db->f('id')] = new VIH_Model_LangtKursus_Tilmelding($db->f('id'));
        }
        return count($list);
    }

    //////////////////////////////////////////////////////////////////////////////
    // RATER
    //////////////////////////////////////////////////////////////////////////////

    public function antalRater()
    {
        $db = new DB_Sql;
        $db->query("SELECT * FROM langtkursus_rate WHERE langtkursus_id = ".$this->id);
        return $db->numRows();
    }

    public function opretRater($antal, $foerste_rate_dato)
    {
        if ($this->antalRater() == 0) {
            $db = new DB_Sql;
            $dato = new VIH_Date($foerste_rate_dato);
            if ($dato->convert2db() == false) {
                trigger_error("Ugydlig datoformat", E_USER_ERROR);
            }

            $dato_parts = explode("-", $dato->get());

            for($i = 0; $i < $antal; $i++) {
                $betalingsdato = date("Y-m-d", mktime(0, 0, 0, intval($dato_parts[1])+$i, $dato_parts[2], $dato_parts[0]));
                $db->query("INSERT INTO langtkursus_rate SET langtkursus_id = ".$this->id.", betalingsdato = \"".$betalingsdato."\"");
            }
        }
        return 1;
    }

    public function getRater()
    {
        $db = new DB_Sql;
        $i = 0;


        $db->query("SELECT *, DATE_FORMAT(betalingsdato, '%d-%m-%Y') AS dk_betalingsdato FROM langtkursus_rate WHERE langtkursus_id = ".$this->id." ORDER BY betalingsdato");
        while($db->nextRecord()) {

            $rate[$i]["id"] = $db->f("id");
            $rate[$i]["dk_betalingsdato"] = $db->f("dk_betalingsdato");
            $rate[$i]["beloeb"] = $db->f("beloeb");

            $i++;
        }

        return $rate;
    }

    public function updateRater($rater)
    {
        if (is_array($rater)) {
            $db = new DB_Sql;

            for($i = 0, $max = count($rater); $i < $max; $i++) {
                $dato = new VIH_Date($rater[$i]["betalingsdato"]);
                if ($dato->convert2db()) {
                    $db->query("UPDATE langtkursus_rate SET betalingsdato = \"".$dato->get()."\", beloeb = \"".intval($rater[$i]["beloeb"])."\" WHERE id = ".intval($rater[$i]["id"])." AND langtkursus_id = ".$this->get("id"));
                }
            }
        }
        return 1;
    }


    public function addRate($number)
    {
        settype($number, "integer");
        $db = new DB_Sql;

        if ($number > 0) {

            $db->query("SELECT DATE_FORMAT(betalingsdato, '%d') AS d, DATE_FORMAT(betalingsdato, '%m') AS m, DATE_FORMAT(betalingsdato, '%Y') AS y
                FROM langtkursus_rate WHERE langtkursus_id = ".$this->id." ORDER BY betalingsdato DESC LIMIT 1");
            $db->nextRecord() OR trigger_error("Kan ikke tilføje er rate, hvis der ikke eksistere nogen", FATAL);


            for($i = 0; $i < $number; $i++) {
                $betalingsdato = date("Y-m-d", mktime(0, 0, 0, $db->f("m")+$i+1, $db->f("d"), $db->f("y")));
                $db->query("INSERT INTO langtkursus_rate SET langtkursus_id = ".$this->id.", betalingsdato = \"".$betalingsdato."\"");
            }
        }

        if ($number < 0) {
            $number *= -1;
            $db->query("DELETE FROM langtkursus_rate WHERE langtkursus_id = ".$this->id." ORDER BY betalingsdato DESC LIMIT ". $number);
        }
        return 1;
    }

    public function rateDifference()
    {
        $db = new DB_Sql;
        $rate_samlet = 0;

        $db->query("SELECT beloeb FROM langtkursus_rate WHERE langtkursus_id = ".$this->id);
        while($db->nextRecord()) {
            $rate_samlet += $db->f("beloeb");
        }

        return $rate_samlet + $this->get("depositum") - ($this->get("ugeantal") * $this->get("ugepris")) - $this->get("materialepris") - $this->get("rejsedepositum") - $this->get("rejsepris") - $this->get("noegledepositum");

    }

    //////////////////////////////////////////////////////////////////////////////
    // ANDRE METODER
    //////////////////////////////////////////////////////////////////////////////
    private function getLastModified()
    {
        $db = new DB_Sql;
        $db->query("SELECT date_updated FROM langtkursus ORDER BY date_updated DESC LIMIT 1");
        if (!$db->nextRecord()) {
            return 0;
        }
        return strftime("%a, %d %b %Y %H:%I:%S %z", strtotime($db->f("date_updated")));
    }

    //////////////////////////////////////////////////////////////////////////////
    // BILLEDER
    //////////////////////////////////////////////////////////////////////////////

    public function addPicture($file_id)
    {
        $db = new DB_Sql;
        $db->query('INSERT INTO langtkursus_x_file SET file_id = ' . $file_id . ', langtkursus_id = ' . $this->id);
        return 1;
    }

    public function deletePicture($id)
    {
        $db = new DB_Sql;
        $db->query('DELETE FROM langtkursus_x_file WHERE file_id = ' . $id);
        return 1;
    }

    public function getPictures()
    {
        $db = new DB_Sql;
        $db->query("SELECT * FROM langtkursus_x_file WHERE langtkursus_id = " . $this->id);
        $id = array();
        while ($db->nextRecord()) {
            $id[]['file_id'] = $db->f('file_id');
        }
        return $id;
    }

    function getId()
    {
        return $this->id;
    }
}
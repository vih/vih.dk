<?php
/**
 * Deltagere
 *
 * @package Tilmelding (korte kurser)
 * @author Lars Olesen <lars@legestue.net>
 */
class VIH_Model_KortKursus_Tilmelding_Deltager
{
    protected $id;
    public $tilmelding; // object
    protected $value = array();

    public function __construct($tilmelding, $id = 0)
    {
        if (!is_object($tilmelding)) {
            throw new Exception('Deltager kræver en tilmelding');
        }
        $this->tilmelding = $tilmelding;
        $this->id = (int)$id;

        if ($this->id > 0) {
            $this->load();
        }
    }

    public function delete()
    {
        if ($this->id == 0) {
            return 0;
        }
        $db = new DB_Sql;
        $db->query("UPDATE " . TABLE_KORTKURSUS_TILMELDING_DELTAGER . " SET date_updated = NOW(), active = 0 WHERE id = " . $this->id);
        return true;
    }

    public function add()
    {
        $db = new DB_Sql;
        $db->query("INSERT INTO " . TABLE_KORTKURSUS_TILMELDING_DELTAGER . " SET tilmelding_id = " . $this->tilmelding->get('id'));
        return true;
    }

    protected function validate($var)
    {
        $return = true;

        $validate = new Validate;
        if(!$validate->string($var['navn'], array('min_length' => 1))) $return = false;

        return $return;
    }

    public function save($var)
    {
        $var = array_map('mysql_escape_string', $var);
        $var = array_map('strip_tags', $var);
        $var = array_map('trim', $var);

        $var['cpr'] = str_replace('-', '', $var['cpr']);

        if (!$this->validate($var)) {
            return false;
        }

        if ($this->id > 0) {
            $sql_type = "UPDATE ";
            $sql_end = " WHERE id = " . $this->id;
        } else {
            $sql_type = "INSERT INTO ";
            $sql_end = '';
        }

        // @todo hack because enevaerelse og sambo is only set when?
        settype($var['indkvartering_key'], 'integer');
        settype($var['sambo'], 'string');

        $navn = vih_split_name($var['navn']);
        $fornavn = $navn['fornavn'];
        $efternavn = $navn['efternavn'];

        $sql = $sql_type . TABLE_KORTKURSUS_TILMELDING_DELTAGER . "
                SET tilmelding_id = ".$this->tilmelding->getId().",
                    fornavn = '".$fornavn."',
                    efternavn = '".$efternavn."',
                    cpr = '".$var['cpr']."',
                    indkvartering_key = '".$var['indkvartering_key']."'" . $sql_end;

        $db = new DB_Sql;
        $db->query($sql);

        if ($this->id == 0) {
            $this->id = $db->insertedId();
        }

        $this->load();

        // vi skal have gemt nogle deltageroplysninger

        //Fælles oplysninger
        $oplysning = new VIH_Model_KortKursus_Tilmelding_DeltagerOplysning($this);
        $oplysning->save('sambo', $var['sambo']);

        // klassen skal selv vide, hvilken type kursus og agere derefter
        $kursustype = $this->tilmelding->getKursus()->get("gruppe_id");

        switch ($kursustype) {

            case '1': // golf
                $oplysning->save('handicap', (float)$var['handicap']);
                $oplysning->save('klub', $var['klub']);
                $oplysning->save('dgu', $var['dgu']);
                break;

            case '2': // andre
                break;

            case '3': // bridge
                $oplysning->save('niveau', $var['niveau']);
                break;

            case '4': // golf og bridge
                $oplysning->save('handicap', (float)$var['handicap']);
                $oplysning->save('klub', $var['klub']);
                $oplysning->save('dgu', $var['dgu']);
                $oplysning->save('niveau', $var['niveau']);
                break;

            case 5:
                $oplysning->save('speciale', $var['speciale']);


            default:
                break;

        }
        $this->load();

        return $this->id;
    }

    public function get($key = '')
    {
        if (!empty($key)) {
            if (!empty($this->value[$key])) {
                return $this->value[$key];
            }
            return '';
        }

        return $this->value;
    }

    function getOplysninger()
    {
        return new VIH_Model_KortKursus_Tilmelding_DeltagerOplysning($this);
    }

    protected function load()
    {
        $db = new DB_Sql;
        $sql = "SELECT * FROM " . TABLE_KORTKURSUS_TILMELDING_DELTAGER . " WHERE id = " . $this->id . " LIMIT 1";
        $db->query($sql);
        if (!$db->nextRecord()) {
            return 0;
        }

        $this->value['id'] = $db->f('id');
        $this->value['fornavn'] = $db->f('fornavn');
        $this->value['efternavn'] = $db->f('efternavn');
        $this->value['navn'] = trim($this->value['fornavn'] . ' ' . $this->value['efternavn']);
        $this->value['cpr'] = $db->f('cpr');
        $this->value['birthday'] = $this->getBirthday($this->value['cpr']);
        $this->value['indkvartering_key'] = $db->f('indkvartering_key');

        //Fælles oplysninger
        $oplysning = new VIH_Model_KortKursus_Tilmelding_DeltagerOplysning($this);
        $this->value['sambo'] = $oplysning->get('sambo');

        // klassen skal selv vide, hvilken type kursus og agere derefter
        if (is_object($this->tilmelding->kursus)) {
            $kursustype = $this->tilmelding->kursus->get('gruppe_id');

            switch ($kursustype) {

                case '1': // golf
                    $this->value['handicap'] = $oplysning->get('handicap');
                    $this->value['klub'] = $oplysning->get('klub');
                    $this->value['dgu'] = $oplysning->get('dgu');
                    break;

                case '2': // almindelig
                    // ingen ekstraindstillinger
                    break;

                case '3': // bridge
                    $this->value['niveau'] = $oplysning->get('niveau');
                    break;

                case '4': // golf og bridge
                    $this->value['handicap'] = $oplysning->get('handicap');
                    $this->value['klub'] = $oplysning->get('klub');
                    $this->value['dgu'] = $oplysning->get('dgu');
                    $this->value['niveau'] = $oplysning->get('niveau');
                    break;
                case 5: // camp
                    $this->value['speciale'] = $oplysning->get('speciale');
                    break;

                default:
                    break;

            }
            if ($this->getAge() < 17.5) {
                if ($this->tilmelding->kursus->get('pris_boern') > 0) {
                    $this->value['pris'] = $this->tilmelding->kursus->get('pris_boern');
                } else {
                    $this->value['pris'] = $this->tilmelding->kursus->get('pris');
                }
            } else {
                $this->value['pris'] = $this->tilmelding->kursus->get('pris');
            }
        }

        return 1;
    }

    protected function getBirthday($cpr)
    {
        $month = substr($cpr,2,2);
        $day = substr($cpr,0,2);
        $year_last_two_digits = substr($cpr,4,2); // to sidste i årstallet taget fra cprnummeret
        $testyear = (substr(date('Y'), 0,2) - 1) . $year_last_two_digits; // trækker en fra aktuelle år
        if ($testyear < date('Y') AND (date('Y') - $testyear) < 100) {
            $year = (substr(date('Y'), 0,2) - 1) . $year_last_two_digits;
        } else {
            $year = substr(date('Y'), 0 , 2) . $year_last_two_digits;
        }
        return $year . '-' . $month . '-' . $day;
    }

    public function getAge()
    {
        return round(vih_calculate_age($this->value['birthday'], $this->tilmelding->kursus->get('startdato')), 0);
    }

    function getIndkvartering()
    {
        $out = array('price' => 0, 'text' => 'Ingen valgt');
        if ($this->get('indkvartering_key') == 0) {
            return $out;
        }

        $db = new DB_Sql;
        $gateway = new VIH_Model_KortKursus_Indkvartering($this->tilmelding->kursus);
        $db->query('SELECT id, price FROM kortkursus_x_indkvartering WHERE kursus_id = ' . $this->tilmelding->kursus->getId() . ' AND indkvartering_key = ' . $this->get('indkvartering_key'));
        while ($db->nextRecord()) {
            $out['price'] = $db->f('price');
            $out['text'] = $gateway->getType($this->get('indkvartering_key'));
        }
        return $out;
    }
}
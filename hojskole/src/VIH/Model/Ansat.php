<?php
/**
 * @todo De ansatte skal gemmes med en type. Formentlig skal
 *       den være så man kan have flere funktioner.
 */
class VIH_Model_Ansat
{
    private $id;
    private $value;
    public $funktion = array(
        1 => 'administration',
        2 => 'lærer',
        3 => 'køkken',
        4 => 'pedel',
        5 => 'rengøring',
        6 => 'elevforening',
        7 => 'elevchat'
    );

    function __construct($id = 0)
    {
        $this->id = (int)$id;
        if ($this->id > 0) {
            $this->load();
        }
    }

    function load()
    {
        $db = new DB_Sql;
        $db->query("SELECT *, DATE_FORMAT(date_birthday, '%d-%m-%Y') AS date_birthday_dk FROM ansat WHERE id = " . $this->id);
        if (!$db->nextRecord()) {
            return 0;
        }
        $this->value['id'] = $db->f('id');
        $this->value['navn'] = $db->f('fornavn') . ' ' . $db->f('efternavn');
        $this->value['funktion_id'] = $db->f('funktion_id');
        $this->value['adresse'] = $db->f('adresse');
        $this->value['postnr'] = $db->f('postnr');
        $this->value['postby'] = $db->f('postby');
        $this->value['extra_info'] = $db->f('extra_info');
        $this->value['titel'] = $db->f('titel');
        $this->value['beskrivelse'] = $db->f('beskrivelse');
        $this->value['telefon'] = $db->f('telefon');
        $this->value['mobil'] = $db->f('mobil');
        $this->value['email'] = $db->f('email');
        $this->value['website'] = $db->f('website');
        $this->value['date_birthday'] = $db->f('date_birthday');
        $this->value['date_birthday_dk'] = $db->f('date_birthday_dk');
        $this->value['date_ansat'] = $db->f('date_ansat');
        $this->value['date_stoppet'] = $db->f('date_stoppet');
        $this->value['published'] = $db->f('published');
        $this->value['pic_id'] = $db->f('pic_id');
        return 1;
    }

    function getExtraInfo()
    {
        return $this->value['extra_info'];
    }

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

    function validate()
    {
        return 1;
    }

    function save($var)
    {
        if (!isset($var['published'])) {
            $var['published'] = 0;
        }
        $var = array_map('mysql_escape_string', $var);

        if (!is_array($var)) {
            return 0;
        } elseif (!$this->validate()) {
            return 0;
        }

        $db = new DB_Sql;

        if ($this->id == 0) {
            $sql_type = "INSERT INTO ";
            $sql_end = ", date_created = NOW()";
        } else {
            $sql_type = "UPDATE ";
            $sql_end = " WHERE id = " . $this->id;
        }

        $navn = vih_split_name($var['navn']);

        $sql_items  = "fornavn = '".$navn['fornavn']."',";
        $sql_items .= "efternavn = '".$navn['efternavn']."',";
        $sql_items .= "adresse = '".$var['adresse']."',";
        $sql_items .= "postnr = '".$var['postnr']."',";
        $sql_items .= "postby = '".$var['postby']."',";
        $sql_items .= "date_birthday = '".$var['date_birthday']."',";
        $sql_items .= "date_ansat = '".$var['date_ansat']."',";
        $sql_items .= "date_stoppet = '".$var['date_stoppet']."',";
        $sql_items .= "titel = '".$var['titel']."',";
        $sql_items .= "extra_info = '".$var['extra_info']."',";
        $sql_items .= "beskrivelse = '".$var['beskrivelse']."',";
        $sql_items .= "telefon = '".$var['telefon']."',";
        $sql_items .= "mobil = '".$var['mobil']."',";
        $sql_items .= "email = '".$var['email']."',";
        $sql_items .= "funktion_id = '".$var['funktion_id']."',";
        $sql_items .= "website = '".$var['website']."',";
        $sql_items .= "published = '".(int)$var['published']."',";

        $db->query($sql_type . " ansat SET " . $sql_items . " date_updated = NOW()" . $sql_end);

        if ($this->id == 0) {
            $this->id = $db->insertedId();
        }

        return $this->id;

    }

    function delete()
    {
        $db = new DB_Sql;
        $db->query("UPDATE ansat SET date_updated = NOW(), active = 0 WHERE id = " . $this->id);
        return 1;
    }


    function getList($type = '')
    {
        $db = new DB_Sql;

        switch ($type) {
            case 'lærere': // fall through
            case 'undervisere':
                    $sql = "SELECT id FROM ansat WHERE active = 1 AND funktion_id = 2 AND published = 1 ORDER BY fornavn ASC";
                break;
            case 'elevchatter':
                    $sql = "SELECT id FROM ansat WHERE active = 1 AND funktion_id = 7 AND published = 1 ORDER BY fornavn ASC LIMIT 1";
                break;

            default:
                    $sql = "SELECT id FROM ansat WHERE active = 1 ORDER BY fornavn ASC";
                break;
        }

        $db->query($sql);
        $list = array();
        while ($db->nextRecord()) {
            $list[] = new VIH_Model_Ansat($db->f('id'));
        }
        return $list;
    }

    function getBirthdays()
    {
        $db = new DB_Sql;
        $db->query("SELECT id FROM ansat WHERE DATE_FORMAT(date_birthday, '%m-%d') = DATE_FORMAT(NOW(), '%m-%d')");
        $list = array();
        while($db->nextRecord()) {
            $list[] = new VIH_Model_Ansat($db->f('id'));
        }
        return $list;
    }

    function getStatusKey($key)
    {
        return array_search($key, $this->funktion);
    }

    function getFag()
    {
        $db = new DB_Sql;
        $db->query("SELECT * FROM ansat_x_fag INNER JOIN langtkursus_fag fag ON ansat_x_fag.fag_id = fag.id WHERE ansat_id = " . $this->id . " AND fag.active = 1 AND fag.published = 1");
        $fag = array();
        while ($db->nextRecord()) {
            $fag[] = new VIH_Model_Fag($db->f('fag_id'));
        }

        return $fag;

    }

    function addPicture($file_id)
    {
        if ($this->id == 0) {
            return 0;
        }

        $db = new DB_Sql;
        $db->query('UPDATE ansat SET pic_id = '.$file_id.', date_updated = NOW() WHERE id = ' . $this->id);
        return 1;
    }
}
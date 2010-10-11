<?php
/**
 * Denne klasse bruges til navne og adresser p� alle tilmeldinger.
 *
 * @package Tilmelding
 * @author Lars Olesen <lars@legestue.net>
 */
class VIH_Model_Adresse
{
    public $id;
    public $value;

    function __construct($id = 0) {
        $this->id = (int)$id;

        if ($this->id > 0) {
            $this->load();
        }
    }

    function load()
    {
        $db = new DB_Sql;
        $sql = "SELECT id, fornavn, efternavn, adresse, postnr, postby, arbejdstelefon, telefon, mobil, email FROM adresse WHERE id = " . $this->id . " LIMIT 1";
        $db->query($sql);
        if (!$db->nextRecord()) {
            return 0;
        }

        $this->id = $db->f('id');
        $this->value['id'] = $db->f('id');
        $this->value['navn'] = trim($db->f('fornavn') . ' ' . $db->f('efternavn'));
        $this->value['fornavn'] = $db->f('fornavn');
        $this->value['efternavn'] = $db->f('efternavn');
        $this->value['adresse'] = $db->f('adresse');
        $this->value['postnr'] = $db->f('postnr');
        $this->value['postby'] = $db->f('postby');
        $this->value['arbejdstelefon'] = $db->f('arbejdstelefon');
        $this->value['telefon'] = $db->f('telefon');
        $this->value['mobil'] = $db->f('mobil');
        $this->value['email'] = $db->f('email');

        return 1;
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

    function validate($input)
    {
        $error = array();
        /*
        $validate = new Validate;
        if (!$validate->string($input['navn'], array('min_length' => 1))) $error[] = "navn";
        if (isset($input['adresse']) && $input['adresse'] != "") {
            if (!$validate->string($input['adresse'], array('min_length' => 1))) $error[] = "adresse";
        }
        if (isset($input['postnr']) && $input['postnr'] != "") {
            if (!$validate->number($input['postnr'], array('min' => 100))) $error[] = "postnr";
        }
        if (isset($input['postby']) && $input['postby'] != "") {
            if (!$validate->string($input['postby'], array('min_length' => 1))) $error[] = "postby";
        }

        if (isset($input['email']) && $input['email'] != "") {
            if (!$validate->email($input['email'])) $error[] = "email";
        }
        if (isset($input['arbejdstelefon']) && $input['arbejdstelefon'] != "") {
            if (!$validate->string($input['arbejdstelefon'], array('min_length' => 8))) $error[] = "arbejdstelefon";
        }
        if (isset($input['telefonnummer']) && $input['telefonnummer'] != "") {
            if (!$validate->string($input['telefonnummer'], array('min_length' => 8))) $error[] = "telefon";
        }
        if (isset($input['mobil']) && $input['mobil'] != "") {
            if (!$validate->string($input['mobil'], array('min_length' => 8))) $error[] = "mobil";
        }
        */
        if (count($error) > 0) {
            //print_r($error);
            return false;
        } else {
            return true;
        }
    }

    /**
     *
     * Der m� i denne funktion ikke bruges array_map() til at genneml�be
     * v�rdierne, da den �del�gger arrayet til andet brug.
     * Sune: Nu har jeg alligevel benyttet array_map, for jeg kan ikke se hvor man ikke kan det.
     */
    function save($input)
    {
        settype($input['arbejdstelefon'], 'string');
        settype($input['mobil'], 'string');
        settype($input['adresse'], 'string');
        settype($input['postnr'], 'string');
        settype($input['postby'], 'string');

        if (!$this->validate($input)) {
            return 0;
        }

        $var = $input;

        $navn = vih_split_name($var['navn']);
        $var['fornavn'] = $navn['fornavn'];
        $var['efternavn'] = $navn['efternavn'];

        if ($this->id == 0) {
            $sql_type = "INSERT INTO ";
            $sql_end = ", date_created = NOW()";
        } else {
            $sql_type = "UPDATE ";
            $sql_end = ", date_changed = NOW() WHERE id = " . $this->id;
        }
        $sql = $sql_type . "adresse SET
            fornavn = '".$var['fornavn']."',
            efternavn = '".$var['efternavn']."',
            adresse = '".$var['adresse']."',
            postnr = '".$var['postnr']."',
            postby = '".$var['postby']."',
            email = '".$var['email']."',
            arbejdstelefon = '".$var['arbejdstelefon']."',
            telefon = '".$var['telefonnummer']."',
            mobil = '".$var['mobil']."'" . $sql_end;

        $db = new DB_Sql;
        $db->query($sql);

        if ($this->id == 0) {
            return $db->insertedId();
        }

        $this->load();

        return $this->id;

    }
}
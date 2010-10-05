<?php
/**
 *
 * @author Lars Olesen <lars@legestue.net>
 * @author Sune Jensen <sj@sunet.dk>
 */
class VIH_Model_MaterialeBestilling
{

    private $id;

    function __construct($id = 0)
    {
        if (!is_numeric($id)) {
            throw new Exception('MaterialeBestilling::MaterialeBestilling $id skal v�re numerisk');
        }
        $this->id = (int)$id;
    }

    function validate($values)
    {
        $return = true;

        $validate = new Validate;
        if (!$validate->string($values['navn'], array('min_length' => 1))) $return = false;
        if (!$validate->string($values['adresse'], array('min_length' => 1))) $return = false;
        if (!$validate->number($values['postnr'], array('min' => 100))) $return = false;
        if (!$validate->string($values['postby'], array('min_length' => 1))) $return = false;
        if (!empty($values['email']) AND !$validate->email($values['email'])) $return = false;
        /*
        if (isset($values['langekurser']) != "" && $values['langekurser'] != "1") $return = false;
        if (isset($values['kortekurser']) != "" && $values['kortekurser'] != "1") $return = false;
        if (isset($values['efterskole']) != "" && $values['efterskole'] != "1") $return = false;
        if (isset($values['kursuscenter']) != "" && $values['kursuscenter'] != "1") $return = false;
        */
        return $return;

    }

    function save($values)
    {
        $values = array_map("mysql_escape_string", $values);
        $values = array_map("strip_tags", $values);
        $values = array_map("trim", $values);

        settype($values["langekurser"], 'integer');
        settype($values["kortekurser"], 'integer');
        settype($values["kursuscenter"], 'integer');
        settype($values["efterskole"], 'integer');

        if (!$this->validate($values)) {
            return false;
        }

        $sql = "navn = \"".$values["navn"]."\",
            adresse = \"".$values["adresse"]."\",
            postnr = \"".$values["postnr"]."\",
            postby = \"".$values["postby"]."\",
            email = \"".$values["email"]."\",
            telefon = \"".$values["telefon"]."\",
            besked = \"".$values["besked"]."\",
            langekurser = \"".$values["langekurser"]."\",
            kortekurser = \"".$values["kortekurser"]."\",
            kursuscenter = \"".$values["kursuscenter"]."\",
            efterskole = \"".$values["efterskole"]."\",
            date_created = NOW()";


        $db = new DB_Sql;
        $db->query("INSERT INTO materialebestilling SET " . $sql);

        return true;
    }

    function setSent()
    {
        $db = new DB_Sql;
        $db->query("UPDATE materialebestilling SET er_sendt = 1 WHERE id = " . $this->id);
        return 1;
    }

    function getList($type = '')
    {
        $value = array();
        $i = 0;

        $db = new DB_Sql;

        if ($type=='all') {
            $db->query("SELECT *, DATE_FORMAT(date_created, '%d-%m-%Y %H:%i') AS date_dk FROM materialebestilling ORDER BY date_created");
        } else {
            $db->query("SELECT *, DATE_FORMAT(date_created, '%d-%m-%Y %H:%i') AS date_dk FROM materialebestilling WHERE er_sendt = 0 ORDER BY date_created");
        }
        while($db->nextRecord()) {
            $value[$i]['id'] = $db->f('id');
            $value[$i]['navn'] = $db->f('navn');
            $value[$i]['adresse'] = $db->f('adresse');
            $value[$i]['postnr'] = $db->f('postnr');
            $value[$i]['postby'] = $db->f('postby');
            $value[$i]['email'] = $db->f('email');
            $value[$i]['telefon'] = $db->f('telefon');
            $value[$i]['langekurser'] = $db->f('langekurser');
            $value[$i]['kortekurser'] = $db->f('kortekurser');
            $value[$i]['kursuscenter'] = $db->f('kursuscenter');
            $value[$i]['efterskole'] = $db->f('efterskole');
            $value[$i]['besked'] = $db->f('besked');
            $value[$i]['date_dk'] = $db->f('date_dk');
            $value[$i]['er_sendt'] = $db->f('er_sendt');
            $i++;
        }

        return $value;
    }
}

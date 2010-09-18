<?php
/**
 * @package Venteliste (b�de korte og lange kurser)
 * @author Sune Jensen <sj@sunet.dk>
 */
class VIH_Model_Venteliste
{
    public $id;
    public $belong_to;
    public $belong_to_id;
    public $adresse;

    /**
    * @param belong_to: enten 1 for langt kursus, 2 for kort kursus
    * @param belong_to_id: id p� det entel langt eller kort kursus, som denne ventelisteperson er tilknyttet
    * @param id: id p� ventelisteperson
    */
    function __construct($belong_to, $belong_to_id, $id = 0)
    {
        $this->id = (int)$id;

        settype($belong_to, "integer");
        if (!in_array($belong_to, array(1,2))) {
            die("Ugyldig belong_to");
        }
        $this->belong_to = $belong_to;
        $this->belong_to_id = (int)$belong_to_id;

        $this->load();
    }

    /**
     * Returnerer v�rdier
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
     * Loader v�rdier
     */
    function load()
    {
        // Informationer om kurser.
        if ($this->belong_to == 1 && $this->belong_to_id != 0) { // Kort kursus
            $kortkursus = new VIH_Model_KortKursus($this->belong_to_id);
            $this->value["kursusnavn"] = $kortkursus->get("kursusnavn");
            $this->value["kursus_id"] = $kortkursus->get("id");

        } elseif ($this->belong_to == 2) { // Langt kursus
            throw new Exception("Lange kurser Endnu ikke implementeret i load");
        }


        if ($this->id == 0) {
            return 1;
        }

        $db = new DB_Sql;

        $db->query("SELECT * FROM venteliste WHERE id = ".$this->id);
        $db->nextRecord() OR die("Ugyldig id");

        $this->value["id"] = $db->f("id");
        $this->value["adresse_id"] = $db->f("adresse_id");
        $this->value["antal"] = $db->f("antal");
        $this->value["besked"] = $db->f("besked");

        $this->adresse = new VIH_Model_Adresse($db->f("adresse_id"));

        return 1;
    }


    /**
     * Bruges til at slette en fra venteliste
     *
     * @return 1 on success
     */
    function delete()
    {
        if ($this->id == 0) {
            return 0;
        }
        $db = new DB_Sql;
        $db->query("UPDATE venteliste SET active = 0, date_updated = NOW() WHERE id = ".$this->id);

        return 1;
    }

    /**
     * Bruges til at validere input date.
     *
     * @return true on success
     */
    function validate($var)
    {
        $error = array();

        if (!Validate::number($var['antal'], array('min' => 1))) $error[] = "antal";

        if (count($error) > 0) {
            print_r($error);
            return false;
        } else {
            return true;
        }
    }

    /**
     * Bruges til at opdatere ventelisteperson
     *
     * @return inserted id on success
     */
    function save($var)
    {
        $var = array_map("mysql_escape_string", $var);
        $var = array_map("strip_tags", $var);
        $var = array_map("trim", $var);

        if (!$this->validate($var)) {
            return 0;
        }

        // Adresse gemmes
        $adresse = new VIH_Model_Adresse((int)$this->get('adresse_id'));
        if (!$adresse_id = $adresse->save($var)) {
            return 0;
        }

        // her laves sql-typerne
        if ($this->id > 0) {
            $sql_type = "UPDATE ";
            $sql_end = " WHERE id = " . $this->id;
        } else {
            $sql_type = "INSERT INTO ";
            $sql_end = ', date_created = NOW(), belong_to = '.$this->belong_to.', belong_to_id = '.$this->belong_to_id;
        }

        $sql = $sql_type."venteliste SET
                date_updated = NOW(),
                adresse_id = ".$adresse_id.",
                besked = '".$var['besked']."',
                antal = ".$var['antal']."
            ".$sql_end;

        $db = new DB_Sql;
        $db->query($sql);

        if ($this->id == 0) {
            $this->id = $db->insertedId();
        }

        $this->load();

        return $this->id;

    }

    /**
     * Giver list over personer p� ventelisten
     *
     * @return array med ventelistepersoner
     */
    function getList()
    {
        $sql = "SELECT *, DATE_FORMAT(date_created, '%d-%m-%Y') AS date_created_dk FROM venteliste
            WHERE belong_to = ".$this->belong_to." AND belong_to_id = ".$this->belong_to_id." AND active = 1
            ORDER BY date_created";
        $db = new DB_Sql;
        $db->query($sql);

        $venteliste = array();
        $i = 0;
        $nummer = 1;

        while($db->nextRecord()) {
            $venteliste[$i]['id'] = $db->f("id");
            $venteliste[$i]['nummer'] = $nummer;
            $venteliste[$i]['antal'] = $db->f("antal");
            $venteliste[$i]['kursus_id'] = $db->f('belong_to_id');
            $venteliste[$i]['date_created_dk'] = $db->f('date_created_dk');
            $venteliste[$i]['besked'] = $db->f('besked');
            $nummer++;

            $adresse = new VIH_Model_Adresse($db->f('adresse_id'));
            $venteliste[$i]['adresse_id'] = $adresse->get('id');
            $venteliste[$i]['navn'] = $adresse->get('navn');
            $venteliste[$i]['adresse'] = $adresse->get('adresse');
            $venteliste[$i]['postnr'] = $adresse->get('postnr');
            $venteliste[$i]['postby'] = $adresse->get('postby');

            $venteliste[$i]['telefon'] = $adresse->get('telefon');
            $venteliste[$i]['arbejdstelefon'] = $adresse->get('arbejdstelefon');
            $venteliste[$i]['mobil'] = $adresse->get('mobil');
            $venteliste[$i]['email'] = $adresse->get('email');

            $i++;
        }

        return $venteliste;
    }

    function getNumber()
    {
        if ($this->id == 0) {
            throw new Exception("Du kan kun hente nummer, når der er id på venteliste");
        }

        $venteliste = $this->getList();

        for ($i = 0, $antal = 1, $max = count($venteliste); $i < $max; $i++) {
            if ($venteliste[$i]["id"] == $this->id) {
                return $antal;
            } else {
                $antal += $venteliste[$i]['antal'];
            }
        }
    }

}

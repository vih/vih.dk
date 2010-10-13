<?php
/**
 * Fag
 *
 * @package VIH
 * @author  Lars Olesen <lars@legestue.net>
 * @since   0.1.0
 * @version @package-version@
 */
class VIH_Model_Fag
{
    private $id;
    private $value;

    public function __construct($id = '')
    {
        if (is_numeric($id)) {
            $this->id = $id;
        } elseif (is_string($id)) {
            $db = new DB_Sql;
            $db->query("SELECT id FROM langtkursus_fag WHERE identifier = '".$id."'");
            if ($db->nextRecord()) {
                $this->id = $db->f('id');
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

    private function load()
    {
        $db = new DB_Sql;
        $db->query("SELECT *,
                fag.id AS id,
                fag.navn AS navn,
                fag.beskrivelse AS beskrivelse,
                fag_gruppe.navn AS faggruppe,
                fag_gruppe.beskrivelse AS faggruppe_beskrivelse,
                fag_gruppe.show_description,
                fag.published
            FROM langtkursus_fag fag
            LEFT JOIN langtkursus_fag_gruppe fag_gruppe
                ON fag.fag_gruppe_id = fag_gruppe.id
            WHERE fag.id = " . $this->id);
        if (!$db->nextRecord()) {
            return 0;
        }
        $this->value['id'] = $db->f('id');
        $this->value['navn'] = $db->f('navn');
        $this->value['identifier'] = $db->f('identifier');
        if (empty($this->value['identifier'])) {
            $this->value['identifier'] = $this->value['id'];
        }
        $this->value['title'] = $db->f('title');
        $this->value['description'] = $db->f('description');
        $this->value['keywords'] = $db->f('keywords');
        $this->value['udvidet_beskrivelse'] = $db->f('udvidet_beskrivelse');
        $this->value['kort_beskrivelse'] = $db->f('kort_beskrivelse');
        $this->value['beskrivelse'] = $db->f('beskrivelse');
        $this->value['published'] = (int)$db->f('published');
        $this->value['active'] = (int)$db->f('active');
        $this->value['faggruppe'] = $db->f('faggruppe');
        $this->value['faggruppe_beskrivelse'] = $db->f('faggruppe_beskrivelse');
        $this->value['faggruppe_id'] = $db->f('fag_gruppe_id');
        $this->value['faggruppe_vis_diplom'] = $db->f('vis_diplom');
        $this->value['pic_id'] = $db->f('pic_id');
        $this->value['show_description'] = $db->f('show_description');
        $this->value['published'] = $db->f('published');
        return true;
    }

    function showCourses()
    {
        return $this->value['show_description'];
    }

    public function get($key = '')
    {
        if (empty($key)) {
            return $this->value;
        }
        return $this->value[$key];
    }

    public function save($input)
    {
        if ($this->id > 0) {
            $sql_type = "UPDATE ";
            $sql_end = " WHERE id = " . $this->id;
        } else {
            $sql_type = "INSERT INTO ";
            $sql_end = ", date_created = NOW()";
        }

        $sql = $sql_type . " langtkursus_fag SET
                                    date_updated = NOW(),
                                    navn = '" . mysql_escape_string($input['navn'])  ."',
                                    title = '" . mysql_escape_string($input['title'])  ."',
                                    keywords = '" . mysql_escape_string($input['keywords'])  ."',
                                    fag_gruppe_id = '" . mysql_escape_string($input['faggruppe_id'])  ."',
                                    description = '" . mysql_escape_string($input['description'])  ."',
                                    beskrivelse = '" . mysql_escape_string($input['beskrivelse'])  ."',
                                    kort_beskrivelse = '" . mysql_escape_string($input['kort_beskrivelse'])  ."',
                                    udvidet_beskrivelse = '" . mysql_escape_string($input['udvidet_beskrivelse'])  ."',
                                    identifier = '" . mysql_escape_string($input['identifier'])  ."',
                                    published = '" . (int)$input['published']  ."'" . $sql_end;
        $db = new DB_Sql();
        $db->query($sql);

        if ($this->id == 0) {
            $this->id = $db->insertedId();
        }

        return $this->id;

    }

    public function delete()
    {
        $db = new DB_Sql;
        $db->query("UPDATE langtkursus_fag SET date_updated = NOW(), active = 0 WHERE id = " . $this->id);
        return 1;
    }

    static public function getList($type = '')
    {
        $extra_sql = '';
        $db = new DB_Sql;
        if ($type == 'published') {
            $extra_sql = ' AND fag.published = 1 ';
        }
        $db->query("SELECT fag.id FROM langtkursus_fag fag
            LEFT JOIN langtkursus_fag_gruppe gruppe
                ON fag.fag_gruppe_id = gruppe.id
            WHERE
                fag.active = 1".$extra_sql."
                ORDER BY gruppe.position, fag.fag_gruppe_id, fag.navn ASC");
        $fag = array();
        while ($db->nextRecord()) {
            $fag[] = new VIH_Model_Fag($db->f('id'));
        }
        return $fag;
    }

    static public function getPublished()
    {
        $db = new DB_Sql;
        $extra_sql = ' AND fag.published = 1 ';
        $db->query("SELECT fag.id FROM langtkursus_fag fag
            INNER JOIN langtkursus_fag_gruppe gruppe
                ON fag.fag_gruppe_id = gruppe.id
            WHERE
                fag.active = 1".$extra_sql."
                ORDER BY gruppe.position, fag.fag_gruppe_id, fag.navn ASC");
        $fag = array();
        while ($db->nextRecord()) {
            $fag[] = new VIH_Model_Fag($db->f('id'));
        }
        return $fag;
    }

    static public function getPublishedWithDescription()
    {
        $db = new DB_Sql;
        $db->query("SELECT fag.id FROM langtkursus_fag fag
            INNER JOIN langtkursus_fag_gruppe gruppe
                ON fag.fag_gruppe_id = gruppe.id
            WHERE
                fag.active = 1 AND fag.published = 1 AND show_description = 1
                ORDER BY gruppe.position, fag.fag_gruppe_id, fag.navn ASC");
        $fag = array();
        while ($db->nextRecord()) {
            $fag[] = new VIH_Model_Fag($db->f('id'));
        }
        return $fag;

    }

    //////////////////////////////////////////////////////////////////////////////////////

    public function flushUnderviser()
    {
        $db = new DB_Sql;
        $db->query("DELETE FROM ansat_x_fag WHERE fag_id = " . $this->id);
        return 1;
    }

    /**
     *
     * @param $fag array med fag_id'er
     */

    public function addUnderviser($underviserlist) {
        if (!is_array($underviserlist)) {
            return 0;
        }
        if (!$this->flushUnderviser()) {
            die('Fagene kunne ikke fjernes');
        }
        $db = new DB_Sql;
        foreach ($underviserlist AS $key => $value) {
            $sql = "INSERT INTO ansat_x_fag (fag_id, ansat_id) VALUES (".$this->id.", " . $key . ")";
            $db->query($sql);
        }
    }

    public function getUndervisere()
    {
        $db = new DB_Sql;
        $db->query("SELECT * FROM ansat_x_fag INNER JOIN ansat ON ansat_x_fag.ansat_id = ansat.id WHERE fag_id = " . $this->id . " AND ansat.active = 1 AND ansat.published = 1");
        $underviser = array();
        while ($db->nextRecord()) {
            $underviser[] = new VIH_Model_Ansat($db->f('ansat_id'));
        }
        return $underviser;
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getKurser()
    {
        $db = new DB_Sql;
        $db->query("SELECT * FROM langtkursus_x_fag INNER JOIN langtkursus ON langtkursus_x_fag.langtkursus_id = langtkursus.id WHERE fag_id = " . $this->id . ' AND dato_start > NOW() AND langtkursus.active = 1 AND langtkursus.published = 1 GROUP BY langtkursus_id ORDER BY dato_start');
        $kurser = array();
        while ($db->nextRecord()) {
            $kurser[] = new VIH_Model_LangtKursus($db->f('langtkursus_id'));
        }
        return $kurser;
    }

    function getId()
    {
        return $this->id;
    }
}
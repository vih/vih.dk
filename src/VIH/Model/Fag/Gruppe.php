<?php
/**
 * FagGruppe
 *
 * @package VIH
 * @author  Lars Olesen <lars@legestue.net>
 * @since   0.1.0
 * @version @package-version@
 */
class VIH_Model_Fag_Gruppe
{
    private $id;
    private $values;

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
        $sql = "SELECT * FROM langtkursus_fag_gruppe WHERE id = " . $this->id;
        $db->query($sql);

        while ($db->nextRecord()) {
            $this->values['id'] = $db->f('id');
            $this->values['navn'] = $db->f('navn');
            $this->values['beskrivelse'] = $db->f('beskrivelse');
            $this->values['valgfag'] = $db->f('valgfag');
            $this->values['vis_diplom'] = $db->f('vis_diplom');
            $this->values['show_description'] = $db->f('show_description');
            $this->values['published'] = $db->f('published');
        }
    }

    function get($key = '')
    {
        if (!empty($key)) {
            return $this->values[$key];
        }
        return $this->values;
    }

    function save($input)
    {
        $input = array_map('mysql_escape_string', $input);
        $input = array_map('strip_tags', $input);
        $input = array_map('trim', $input);

        if ($this->id > 0) {
            $sql_type = "UPDATE";
            $sql_end = " WHERE id = " . $this->id;
        } else {
            $sql_type = "INSERT INTO";
            $sql_end = '';
        }

        $db = new DB_Sql;
        $db->query($sql_type . " langtkursus_fag_gruppe
            SET
                show_description = '".$input['show_description']."',
                published='".$input['published']."',
                vis_diplom='".$input['vis_diplom']."',
                valgfag='".$input['valgfag']."',
                navn = '".$input['navn']."', beskrivelse = '".$input['beskrivelse']."'" . $sql_end);

        if ($this->id == 0) {
            $this->id = $db->insertedID();
        }

        return $this->id;
    }

    static public function getList()
    {
        $db = new DB_Sql;
        $db->query("SELECT id FROM langtkursus_fag_gruppe WHERE active = 1");

        $grp = array();

        while ($db->nextRecord()) {
            $grp[] = new VIH_Model_Fag_Gruppe($db->f('id'));
        }
        return $grp;
    }

    function delete()
    {
        $db = new DB_Sql;
        $db->query("UPDATE langtkursus_fag_gruppe SET date_updated = NOW(), active = 0 WHERE id = " . $this->id);
        return true;
    }
}

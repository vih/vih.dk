<?php
class VIH_Model_Facilitet
{

    private $values;
    private $id;
    public $kategori = array(
        1 => 'Idræt',
        2 => 'Højskole',
        3 => 'Omgivelser',
        4 => 'Kursuscenter'
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
        $db = new DB_Sql();
        $db->query("SELECT * FROM facilitet WHERE id=".$this->id . " LIMIT 1");
        if (!$db->nextRecord()) {
            return 0;
        }
        $this->values['id'] = $db->f('id');
        $this->values['navn'] = $db->f('navn');
        $this->values['identifier'] = $db->f('identifier');
        if (empty($this->values['identifier'])) {
            $this->values['identifier'] = $this->values['id'];
        }
        if (empty($this->values['navn'])) {
            $this->values['navn'] = $db->f('overskrift');
        }
        $this->values['beskrivelse'] = $db->f('beskrivelse');
        if (empty($this->values['beskrivelse'])) {
            $this->values['beskrivelse'] = $db->f('tekst');
        }
        $this->values['title'] = $db->f('title');
        $this->values['pic_id'] = $db->f('pic_id');
        $this->values['description'] = $db->f('description');
        $this->values['kategori_id'] = $db->f('kategori_id');
        $this->values['keywords'] = $db->f('keywords');
        $this->values['published'] = $db->f('published');

    }

    function get($key = '')
    {
        if (!empty($key)) {
            return $this->values[$key];
        }
        return $this->values;
    }

    function validate($input)
    {
        return 1;
    }

    function save($input)
    {
        $input = array_map('trim', $input);
        $input = array_map('mysql_escape_string', $input);


        if (!$this->validate($input)) {
            return 0;
        }


        if ($this->id > 0) {
            $sql_type = "UPDATE ";
            $sql_end = " WHERE id = " . $this->id;

        } else {
            $sql_type = "INSERT INTO ";
            $sql_end = ", date_created = NOW()";
        }

        $sql = $sql_type . " facilitet
            SET navn = '".$input['navn']."',
                beskrivelse = '".$input['beskrivelse']."',
                date_updated = NOW(),
                kategori_id = ".$input['kategori_id'].",
                title = '".$input['title']."',
                description = '".$input['description']."',
                keywords = '".$input['keywords']."',
                published = '".(int)$input['published']."',
                identifier = '".$input['identifier']."'
        " . $sql_end;

        $db = new DB_Sql;
        $db->query($sql);

        if ($this->id == 0) {
            return ($this->id = $db->insertedId());
        }
        return $this->id;
    }

    function delete()
    {
        $db = new DB_Sql;
        $db->query("UPDATE facilitet SET active = 0, date_updated = NOW() WHERE id = " . $this->id);
        return 1;
    }

    function getList($type = 'published')
    {
        $db = new DB_Sql;
        $sql = "SELECT id FROM facilitet WHERE active = 1";
        if ($type == 'published') {
            $sql .= " AND published = 1";
        } elseif ($type == 'højskole') {
            $sql .= " AND kategori_id > 0 AND kategori_id < 4 AND published = 1";
        }
        $sql .= " ORDER BY kategori_id, navn";
        $db->query($sql);
        $list = array();
        while ($db->nextRecord()) {
            $list[] = new VIH_Model_Facilitet($db->f('id'));
        }
        return $list;
    }

    function addPicture($file_id)
    {
        $db = new DB_Sql;
        $db->query('UPDATE facilitet SET pic_id = ' . $file_id . ', date_updated = NOW() WHERE id = ' . $this->id);
        return 1;
    }

    function deletePicture($file_id)
    {
        $db = new DB_Sql;
        $db->query('UPDATE facilitet SET pic_id = 0, date_updated = NOW() WHERE id = ' . $this->id);
        return 1;
    }
}
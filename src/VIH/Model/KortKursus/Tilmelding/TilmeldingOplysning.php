<?php
/**
 * Special info for the registration
 *
 * @author Lars Olesen <lars@legestue.net>
 */
class VIH_Model_KortKursus_Tilmelding_TilmeldingOplysning
{
    protected $tilmelding;
    protected $value;
    protected $allowed_types = array(
        'hvilkettidligerekursus'
    );

    public function __construct($tilmelding)
    {
        $this->tilmelding = $tilmelding;

        $this->load();
    }

    protected function validate($art, $indhold)
    {
        if (!in_array($this->allowed_types, $art)) {
            return 0;
        }

        return 1;
    }

    public function save($art, $indhold)
    {
        $art = trim(strip_tags(mysql_escape_string($art)));
        $indhold = trim(strip_tags(mysql_escape_string($indhold)));

        if (!$this->validate($art, $indhold)) {
            return 1;
        }

        $db = new DB_Sql;

        if (!empty($art)) {
            $db->query("SELECT id FROM kortkursus_tilmelding_oplysninger WHERE art = '".$art."' AND tilmelding_id = '".$this->tilmelding->get('id')."'");
            if ($db->nextRecord()) {
                $sql = "UPDATE kortkursus_tilmelding_oplysninger SET indhold = '".$indhold."' WHERE art = '".$art."' AND tilmelding_id = '".$this->tilmelding->get('id')."'";
                $db->query($sql);
            } else {
                $sql = "INSERT INTO kortkursus_tilmelding_oplysninger SET indhold = '".$indhold."', art = '".$art."', tilmelding_id = '".$this->tilmelding->get('id')."'";
                $db->query($sql);
            }
        }
        return true;
    }

    public function get($art)
    {
        if (!in_array($art, $this->allowed_types)) {
            return false;
        }

        if (!empty($this->value[$art])) {
            return $this->value[$art];
        } else {
            return '';
        }
    }

    protected function load()
    {
        $db = new DB_Sql;
        $sql = "SELECT art, indhold FROM kortkursus_tilmelding_oplysninger
            WHERE tilmelding_id = '".$this->tilmelding->get('id')."'";
        $db->query($sql);
        while ($db->nextRecord()) {
            $this->value[$db->f('art')] = $db->f('indhold');
        }
        return true;
    }
}
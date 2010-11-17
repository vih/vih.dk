<?php
/**
 * @author Lars Olesen <lars@legestue.net>
 */
class VIH_Model_KortKursus_Tilmelding_DeltagerOplysning
{
    protected $deltager; // object
    protected $allowed_types = array(
        'sambo', 'handicap', 'niveau', 'klub', 'dgu', 'speciale'
    );
    protected $info = array();

    public function __construct($deltager)
    {
        $this->deltager = $deltager;
    }

    protected function validate($art, $indhold)
    {
        if (!in_array($art, $this->allowed_types)) {
            return false;
        }

        return true;
    }

    public function save($art, $indhold)
    {
        $art = trim(strip_tags(mysql_escape_string($art)));
        $indhold = trim(strip_tags(mysql_escape_string($indhold)));

        if (!$this->validate($art, $indhold)) {
            return false;
        }

        $db = new DB_Sql;

        if (isset($art) AND isset($indhold)) {
            $db->query("SELECT id FROM kortkursus_deltager_oplysninger_ny WHERE art = '".$art."' AND deltager_id = '".$this->deltager->get('id')."'");
            if ($db->nextRecord()) {
                $sql = "UPDATE kortkursus_deltager_oplysninger_ny SET indhold = '".$indhold."' WHERE art = '".$art."' AND deltager_id = '".$this->deltager->get('id')."'";
                $db->query($sql);
            } else {
                $sql = "INSERT INTO kortkursus_deltager_oplysninger_ny SET indhold = '".$indhold."', art = '".$art."', deltager_id = '".$this->deltager->get('id')."'";
                $db->query($sql);
            }
        }
        return true;
    }

    public function get($art)
    {
        if (!empty($this->info[$art])) {
            return $this->info[$art];
        }

        $art = trim(strip_tags(mysql_escape_string($art)));

        $sql = "SELECT art, indhold FROM kortkursus_deltager_oplysninger_ny
            WHERE deltager_id = '".$this->deltager->get('id')."'";

        $db = new DB_Sql;
        $db->query($sql);
        while ($db->nextRecord()) {
            $this->info[$db->f('art')] = $db->f('indhold');
        }

        if (!empty($this->info[$art])) {
            return $this->info[$art];
        }
    }
}

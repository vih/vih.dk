<?php
class VIH_Model_KortKursus_TilmeldingGateway
{
    protected $db;

    function __construct()
    {
        $this->db = new DB_Sql;
    }

    function findById($id)
    {
        return new VIH_Model_KortKursus_Tilmelding($id);
    }

    function findByHandle($handle)
    {
        $handle = mysql_escape_string($handle);
        $handle = strip_tags($handle);
        $handle = trim($handle);

        if (empty($handle)) {
            return false;
        }

        $this->db->query("SELECT id FROM kortkursus_tilmelding WHERE code='".$handle."'");
        if ($this->db->numRows() == 1 AND $this->db->nextRecord()) {
            return new VIH_Model_KortKursus_Tilmelding($this->db->f('id'));
        }
        return false;
    }

    function findByString($string)
    {
        $this->db->query("SELECT DISTINCT(tilmelding.id) FROM kortkursus_tilmelding tilmelding
            INNER JOIN adresse ON adresse.id = tilmelding.adresse_id
            WHERE tilmelding.id='".$string."' OR adresse.fornavn LIKE '%".$string."%' OR adresse.efternavn LIKE '%".$string."%'");
        $list = array();
        $i = 0;
        while ($this->db->nextRecord()) {
            $list[$i] = new VIH_Model_KortKursus_Tilmelding($this->db->f('id'));
            $list[$i]->loadBetaling();
            $i++;
        }
        return $list;
    }

    function findByType($type, $limit = 5)
    {
        return $this->findAll($limit, $type);
    }

    /**
     * Finds all
     *
     * status_key 2 = reserveret; 3 = tilmeldt
     *
     * @param $limit
     * @param $type
     *
     * @return array
     */
    function findAll($limit = 5, $type = '')
    {
        switch ($type) {
            case 'restance': // fall through
                $type = 'forfaldne';
            case 'forfaldne':
                $sql = "SELECT distinct tilmelding.id FROM kortkursus_tilmelding tilmelding
                    WHERE (status_key = 2
                        OR status_key = 3) AND active = 1
                    ORDER BY date_created ASC LIMIT " . $limit;
                break;
            default:
                $sql = "SELECT distinct tilmelding.id FROM kortkursus_tilmelding tilmelding
                    WHERE (status_key >= 2
                        AND status_key <= 4) AND active = 1
                    ORDER BY id DESC LIMIT " . $limit;
                break;
        }

        $db = new DB_Sql;
        $db->query($sql);

        $tilmeldinger = array();

        $i = 0;
        while ($db->nextRecord()) {
            $tilmeldinger[$i] = new VIH_Model_KortKursus_Tilmelding($db->f('id'));
            $tilmeldinger[$i]->loadBetaling();
            $i++;
        }

        return $tilmeldinger;

    }
}

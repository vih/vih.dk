<?php
class VIH_Model_KortKursus_TilmeldingGateway
{
    protected $db;
    protected $status = array(
        -3 => 'venteliste',
        -2 => 'slettet', // if deleted from the system
        -1 => 'annulleret', // if cancelled from the registration process or from the system
        0  => 'ikke tilmeldt', // default setting
        1  => 'undervejs', // when in the registration process
        2  => 'reserveret', // when confirmed under the registration process
        3  => 'tilmeldt', // when deposit has been paid
        4  => 'afsluttet' // when everything has been paid
    );

    function __construct(DB_Sql $db_sql)
    {
        $this->db = $db_sql;
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

        $this->db->query($sql);

        $tilmeldinger = array();

        $i = 0;
        while ($this->db->nextRecord()) {
            $tilmeldinger[$i] = $this->findById($this->db->f('id'));
            $tilmeldinger[$i]->loadBetaling();
            $i++;
        }

        return $tilmeldinger;
    }

    function findBySessionId($session_id)
    {
        $this->db->query("SELECT id FROM kortkursus_tilmelding WHERE session_id = '" . $session_id . "' AND active = 1 AND (status_key = ".$this->getStatusKey('undervejs')." OR ".$this->getStatusKey('reserveret').")");
        if ($this->db->nextRecord()) {
            return $this->findById($this->db->f('id'));
        }
        return new VIH_Model_KortKursus_OnlineTilmelding($session_id);
    }

    function getStatusKey($string)
    {
        return array_search($string, $this->status);
    }
}

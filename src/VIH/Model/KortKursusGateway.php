<?php
class VIH_Model_KortKursusGateway
{
    protected $db;

    function __construct(DB_Sql $db)
    {
        $this->db = $db;
    }

    function findById($id)
    {
        return new VIH_Model_KortKursus($id);
    }

    function getList($type = 'open', $gruppe = '')
    {
        $kurser = array();

        switch ($type) {

            case 'old':
                $sql = "SELECT id
                                    FROM kortkursus
                                    WHERE kortkursus.published = 1
                                        AND tilmeldingsmulighed='Ja'
                                        AND dato_start < NOW()";


                break;
            case 'intranet':
                // kortkursus.published = 1 AND tilmeldingsmulighed='Ja' AND
                $sql = "SELECT id
                                    FROM kortkursus
                                    WHERE
                                        dato_slut > DATE_SUB(NOW(), INTERVAL 14 DAY)";
                break;
            case 'open':
                // fall through
            default:
                $sql = "SELECT id
                                    FROM kortkursus
                                    WHERE kortkursus.published = 1
                                        AND tilmeldingsmulighed='Ja'
                                        AND dato_start >= DATE_FORMAT(NOW(), '%Y-%m-%d')";

                break;

        }

        switch ($gruppe) {
            case "golf":
                $sql .= " AND gruppe_id=1";
                break;
            case "bridge":
                $sql .= " AND gruppe_id=3";
                break;
            case "others":
                $sql .= " AND (gruppe_id <> 1 AND gruppe_id <> 3)";
                break;
            case "sommerhojskole":
                $sql .= " AND (DATE_FORMAT(dato_start, '%m-d%') > '06-28' AND DATE_FORMAT(dato_slut, '%m-d%') < '09-08')";
                break;
            case "familiekursus":
                $sql .= " AND gruppe_id = 4";
                break;
            case "voksen":
                $sql .= " AND type='Voksenkursus'";
                break;
            case "senior":
                $sql .= " AND type='Seniorkursus'";
                break;
            case 'camp':
                $sql .= " AND gruppe_id = 5";
                break;
            case 'cykel':
                $sql .= " AND gruppe_id = 8";
                break;

        }

        $sql .= " ORDER BY dato_start, gruppe_id ASC";
        $this->db = new DB_Sql;
        $this->db->query($sql);
        $i = 0;
        $kursus = array();
        while ($this->db->nextRecord()) {
            $kursus[$i] = $this->findById($this->db->f('id'));
            $kursus[$i]->getPladser();
            $kursus[$i]->ventelisteFactory();
            $i++;
        }

        return $kursus;
    }

}
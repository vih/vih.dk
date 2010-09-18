<?php
class VIH_Model_LangtKursusGateway
{
    function getOld()
    {
        return $this->getList('old');
    }

    public function getList($show = "open")
    {
        $sql_ekstra = "";

        switch($show) {
            case 'åbne': // fall through
            case 'open':
                $sql_ekstra = "published = 1 AND DATE_ADD(dato_start, INTERVAL 14 DAY) > NOW()";
                break;
            case 'aktuelle':
                $sql_ekstra = "dato_slut > NOW()";
                break;
            case 'intranet':
                $sql_ekstra = "dato_slut > DATE_SUB(NOW(), INTERVAL 400 DAY)";
                break;
            case 'old':
                $sql_ekstra = "dato_slut > DATE_SUB(NOW(), INTERVAL 3650 DAY)";
                break;

            default:
                $sql_ekstra = " 1 = 1";
                break;
        }

        $db = new DB_Sql;
        $db->query("SELECT id FROM langtkursus WHERE ".$sql_ekstra." AND active = 1 ORDER BY dato_start ASC, dato_slut DESC, belong_to ASC, navn ASC");
        $kurser = array();

        while ($db->nextRecord()) {
            $kurser[] = new VIH_Model_LangtKursus($db->f('id'));

        }

        return $kurser;
    }

}
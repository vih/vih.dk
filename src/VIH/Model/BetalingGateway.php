<?php
class VIH_Model_BetalingGateway
{
    protected $db;

    function __construct(DB_Sql $db)
    {
        $this->db = $db;
    }

    function getList($show = '')
    {
        die('not working yet');
        $betalinger = array();
        $sql = '';
        $this->value['total_not_approved'] = 0;
        $this->value['total_approved'] = 0;
        $this->value['total_completed'] = 0;

        if($show == "not_approved") {
            $sql = "AND status = 1 AND belong_to <> 3";
        } elseif($show == "elevforeningen") {
            $sql = "AND belong_to = 3";
        } else {
            $sql = "AND belong_to <> 3";
        }

        $howmany_sql = '';

        // denne er sat ind, når vi vil have alle betalingerne.
        // der er vist ikke noget i vejen for at gøre det på den måde?
        if (!empty($this->belong_to_key) AND !empty($this->belong_to_id)) {
            $howmany_sql = "belong_to = ".$this->belong_to_key." AND belong_to_id = " . $this->belong_to_id." AND";
        }

        $this->db->query("SELECT *  FROM betaling WHERE ".$howmany_sql ." status > 0 AND status < 4 AND active = 1 ".$sql." ORDER BY date_created");
        while($this->db->nextRecord()) {

            if($this->db->f('status') == 1) { // completed
                $this->value['total_completed'] += $this->db->f('amount');
            } elseif($this->db->f('status') == 2) { // approved
                $this->value['total_approved'] += $this->db->f('amount');
            }
            $betalinger[] = new VIH_Model_Betaling($this->db->f('id'));
        }

        return $betalinger;
    }
}
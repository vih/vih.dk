<?php
/**
 * Holder styr p� alle betalinger p� h�jskolens side. Klassen er n�dvendig,
 * for at vi kan lave onlinebetaling fra flere steder p� h�jskolens side.
 *
 * @author Lars Olesen <lars@legestue.net>
 * @author Sune Jensen <sj@sunet.dk>
 */
class VIH_Model_Betaling
{
    public $allowed_belong_to = array(
        0 => '_fejl_',
        1 => 'kortekurser',
        2 => 'langekurser',
        3 => 'elevforeningen'
    );
    public $belong_to_key; // number: key i array
    public $belong_to; // string: value i array
    public $belong_to_id;
    public $allowed_type = array(0=> '_fejl_', 1 => 'quickpay', 2 => 'giro', 3 => 'kontant');
    public $value;
    public $allowed_status = array(
        -1 => 'invalid',
        0 => 'created',
        1 => 'completed', //authorized
        2 => 'approved', //capture
        3 => 'cancelled'
    );
    public $id;

    /**
     *
     * @param $belong_to           Hvor g�lder betalingerne til?
     * @param $belong_to_id        Hvilket id g�lder betalingen til
     * @param $id               		Id p� betaling.
     *
     */
    function __construct()
    {
        $arg = func_get_args();

        if (count($arg) == 0) {
            $this->id = 0;
        } elseif (count($arg) == 1) {
            $this->id = (int)$arg[0];
        } elseif (count($arg) == 2) {
            $belong_to_key = array_search($arg[0], $this->allowed_belong_to);
            if ($belong_to_key === false) {
                throw new Exception('Betaling::Betaling - Ulovlig belong_to');
            }
            $this->belong_to_key = (int)$belong_to_key;
            $this->belong_to = $arg[0];
            $this->belong_to_id = (int)$arg[1];
        } else {
            throw new Exception('Betaling::Betaling - Et forkert antal argumenter');
        }

        if ($this->id > 0) {
            $this->load();
        }
    }

    function get($key = '')
    {
        if (!empty($key)) {
            if (!empty($this->value[$key])) {
                return $this->value[$key];
            }
            return '';
        }
        return $this->value;
    }

    function load()
    {
        if ($this->id == 0) {
            return 0;
        }

        $db = new DB_Sql;
        $db->query("SELECT *, DATE_FORMAT(date_created, '%d-%m-%Y') AS date_created_dk FROM betaling WHERE id = ".$this->id);
        if (!$db->nextRecord()) {
            $this->id = 0;
            return 0;
        }

        if ($this->id < 1000) {
            throw new Exception("Id (".$this->id.") på betaling er mindre end 1000. Det må det ikke være da betaling id på quickpay skal være på mindst 4 tegn.");
        }

        $this->belong_to_key = $db->f('belong_to');
        $this->belong_to = $this->allowed_belong_to[$db->f('belong_to')];
        $this->belong_to_id = $db->f('belong_to_id');

        $this->value['id'] = $db->f('id');
        $this->value['belong_to'] = $this->allowed_belong_to[$db->f('belong_to')];
        $this->value['belong_to_key'] = $db->f('belong_to');
        $this->value['belong_to_id'] = $db->f('belong_to_id');
        $this->value['type'] = $db->f('type');
        $this->value['transactionnumber'] = $db->f('transactionnumber');
        # f�lgende b�r lige laves s� status er string og status key er integer - og den s� gemmer i det rigtige felt i datbasen under save() ogs�
        $this->value['status'] = $db->f('status');
        $this->value['status_key'] = $db->f('status');
        $this->value['status_string'] = $this->allowed_status[$db->f('status')];
        $this->value['amount'] = $db->f('amount');
        $this->value['amount_dk'] = $db->f('amount');
        $this->value['date_created_dk'] = $db->f('date_created_dk');

        return $this->id;
    }

    function validate($input)
    {
        $error = array();
        $validate = new Validate;

        if (!$validate->number($input['type'], array('min' => 1 ))) $error[] = "type";
        //if (!$validate->number($input['amount'])) $error[] = "amount";

        if (count($error) > 0) {
            //print_r($error);
            return false;
        } else {
            return true;
        }
    }

    function save($input)
    {
        array_map('trim', $input);
        array_map('strip_tags', $input);
        array_map('mysql_escape_string', $input);

        $type = array_search($input['type'], $this->allowed_type);
        if ($type === false) {
            throw new Exception('Ulovlig type');
        }
        $input['type'] = $type;

        if (!$this->validate($input)) {
            return 0;
        }

        $db = new DB_Sql;

        $db->query("SELECT id FROM betaling ORDER BY id DESC LIMIT 1");
        $db->nextRecord();

        if ($this->id == 0) {
            $sql_type = "INSERT INTO betaling ";
            $sql_end = ", date_created = NOW()";
            if ($db->f('id') < 1000) {
                $sql_end .= ", id = 1000";
            }

        } else {
            $sql_type = "UPDATE betaling ";
            $sql_end = " WHERE id = ".$this->id;
        }

        $db->query($sql_type . " SET
            date_updated = NOW(),
            type = ".$input['type'].",
            belong_to = ".$this->belong_to_key.",
            belong_to_id = ".$this->belong_to_id . ",
            amount = '".$input['amount']."'"
            .$sql_end);

        if ($this->id == 0) {
            $this->id = $db->insertedId();
        }

        $this->load();

        return $this->id;
    }

    function setStatus($status)
    {
        $status = array_search($status, $this->allowed_status);
        if ($status === false) {
            throw new Exception('Ulovlig status');
        }

        if ($this->id == 0) {
            return false;
        }

        if ($status <= $this->get("status") AND $status != -1) { // -1 er ved  invalid, det m� den gerne s�ttes til :D
            throw new Exception("Du kan ikke sætte status lavere eller samme som den allerede er"); // Hvis man kan det, kan man fors�ge at godkende dankortbetaling 2 gange ved quickpay.
        }

        if ($status == 2) { // dankort og approved

            switch($this->get('type')) {
                case 1: // quickpay
                    $historik_type = 'dankort';
                    $historik_comment = 'Godkendt betaling (transact # '.$this->get('transactionnumber').'): '.$this->get('amount_dk').' kr.';
                    $betaling_id = 0;
                    break;
                case 2: // giro
                case 3: // kontant
                    $historik_type = 'manuel';
                    $historik_comment = 'Indtastet betaling: '.$this->get('amount_dk').' kr.';
                    $betaling_id = $this->id;
                    break;
            }
            if (!isset($historik_type)) {
<<<<<<< HEAD:src/VIH/Model/Betaling.php
                trigger_error("Ugyldig type i Betaling->setStatus", E_USER_ERROR);
=======
                throw new Exception("Ugyldig type i Betaling->setStatus");
>>>>>>> a0950209ddcb07df2c8624e904cc61a9513f61ba:src/VIH/Model/Betaling.php
            }



            $historik = new VIH_Model_Historik($this->belong_to, $this->belong_to_id);
            if (!$historik->save(array('type' => $historik_type, 'comment' => $historik_comment, 'betaling_id' => $betaling_id))) {
<<<<<<< HEAD:src/VIH/Model/Betaling.php
                trigger_error("Det lykkedes ikke at gemme en historik ved approval af betaling i Betaling->setStatus", E_USER_ERROR);
=======
                throw new Exception("Det lykkedes ikke at gemme en historik ved approval af betaling i Betaling->setStatus");
>>>>>>> a0950209ddcb07df2c8624e904cc61a9513f61ba:src/VIH/Model/Betaling.php
            }

        }
        $db = new DB_Sql;
        $db->query("UPDATE betaling SET status = ".$status.", date_updated = NOW() WHERE id = ".$this->id);

        return true;
    }

    function setTransactionnumber($number)
    {

        if ($this->id == 0) {
            return false;
        }

        if ((int)$number == 0) {
<<<<<<< HEAD:src/VIH/Model/Betaling.php
            trigger_error("Transactionsnummer er ikke et gyldigt nummer.", E_USER_ERROR);
=======
            throw new Exception("Transactionsnummer er ikke et gyldigt nummer.");
>>>>>>> a0950209ddcb07df2c8624e904cc61a9513f61ba:src/VIH/Model/Betaling.php
        }

        $db = new DB_Sql;
        $db->query("UPDATE betaling SET transactionnumber = ".$number.", date_updated = NOW() WHERE id = ".$this->id);

    }

    function delete()
    {
        if ($this->id == 0) {
            return 0;
        }

        if ($this->get('type') == 1) { // quickpay kan ikke slette! Hvis dette laves om skal der i stedet laves tjek i Historik->delete
            return 0;
        }
        $db = new DB_Sql;
        $db->query("UPDATE betaling SET active = 0 WHERE id  = " . $this->id);
        return 1;
    }

    function search($search)
    {
        $db = new DB_Sql;
        $betalinger = array();
        $db->query("SELECT *  FROM betaling WHERE id = '".$search."'");
        while($db->nextRecord()) {
            $betalinger[] = new VIH_Model_Betaling($db->f('id'));
        }

        return $betalinger;
    }

    function getList($show = '')
    {
        /*
        $gateway = new VIH_Model_BetalingGateway(new DB_Sql);
        return $gateway->getList($show);
        */

        $db = new DB_Sql;
        $betalinger = array();
        $sql = '';
        $this->value['total_not_approved'] = 0;
        $this->value['total_approved'] = 0;
        $this->value['total_completed'] = 0;

        if ($show == "not_approved") {
            $sql = "AND status = 1 AND belong_to <> 3";
        } elseif ($show == "elevforeningen") {
            $sql = "AND belong_to = 3";
        } else {
            $sql = "AND belong_to <> 3";
        }

        $howmany_sql = '';

        // denne er sat ind, n�r vi vil have alle betalingerne.
        // der er vist ikke noget i vejen for at g�re det p� den m�de?
        if (!empty($this->belong_to_key) AND !empty($this->belong_to_id)) {
           $howmany_sql = "belong_to = ".$this->belong_to_key." AND belong_to_id = " . $this->belong_to_id." AND";
        }

        $db->query("SELECT *  FROM betaling WHERE ".$howmany_sql ." status > 0 AND status < 4 AND active = 1 ".$sql." ORDER BY date_created");
        while($db->nextRecord()) {

            if ($db->f('status') == 1) { // completed
                $this->value['total_completed'] += $db->f('amount');
            } elseif ($db->f('status') == 2) { // approved
                $this->value['total_approved'] += $db->f('amount');
            }
            $betalinger[] = new VIH_Model_Betaling($db->f('id'));
        }

        return $betalinger;

    }
}
<?php
/**
 * Historik til kortekurser og langekurser tilmeldinger.
 * Samt mulighed for at implementere det andre steder ligeledes.
 *
 * @author Sune Jensen <sj@sunet.dk>
 */
class VIH_Model_Historik
{
    public $allowed_belong_to = array(
        0 => '_fejl_',
        1 => 'kortekurser',
        2 => 'langekurser',
        3 => 'elevforeningen'
    );
    public $belong_to;
    public $belong_to_id;
    public $allowed_type = array(
        0 => '_fejl_',
        1 => 'manuel',
        2 => 'rykker',
        3 => 'depositumrykker',
        4 => 'depositum',
        5 => 'bekraeftelse',
        6 => 'depositumbekraeftelse',
        7 => 'kode',
        8 => 'dankort',
        9 => 'email',
        10 => 'betalingsopgørelse'
    );
    public $id;

    /**
     *
     * @param $belong_to           Hvor g�lder historikken til?
     * @param $belong_to_id        Hvilket id g�lder historikken til
     * @param $id               		Id p� historik
     *
     */
    function __construct()
    {
        $arg = func_get_args();

        if (count($arg) == 1) {
            $this->id = (int)$arg[0];
        } elseif (count($arg) == 2) {
            $belong_to_key = array_search($arg[0], $this->allowed_belong_to);
            if ($belong_to_key === false) {
                throw new Exception('Historik::historik - Ulovlig belong_to');
            }
            $this->belong_to_key = (int)$belong_to_key;
            $this->belong_to = $arg[0];
            $this->belong_to_id = (int)$arg[1];
        } else {
            throw new Exception('Historik::historik - Et forkert antal argumenter');
        }

        if ($this->id != 0) {
            $this->load();
        }

    }

    function load()
    {
        if ($this->id == 0) {
            return 0;
        }

        $db = new DB_Sql;
        $db->query("SELECT *,DATE_FORMAT(date_created, '%d-%m-%Y') AS date_created_dk FROM historik WHERE id = ".$this->id);
        if (!$db->nextRecord()) {
            $this->id = 0;
            return 0;
        }

        $this->belong_to_key = $db->f('belong_to');
        $this->belong_to = $this->allowed_belong_to[$db->f('belong_to')];
        $this->belong_to_id = $db->f('belong_to_id');

        $this->value['id'] = $db->f('id');
        $this->value['date_created_dk'] = $db->f('date_created_dk');
        $this->value['belong_to_key'] = $db->f('belong_to');
        $this->value['belong_to_id'] = $db->f('belong_to_id');
        $this->value['type_key'] = $db->f('type');
        $this->value['type'] = $this->allowed_type[$db->f('type')];
        $this->value['comment'] = $db->f('comment');
        //$this->value['description'] = $db->f('description');
        $this->value['betaling_id'] = $db->f('betaling_id');

        return $this->id;
    }

    function validate($input)
    {
        $error = array();

        if (!Validate::number($input['type'], array('min' => 1))) $error[] = "type";
        /*
        if (!Validate::string($input['comment'], array('format' => VALIDATE_NUM . VALIDATE_ALPHA . VALIDATE_PUNCTUATION . 'æøåâäüéèÆØÅ-#'))) {
            $error[] = "comment";
        }
        */

        if (count($error) > 0) {
            print_r($error);
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

        settype($input['betaling_id'], 'integer');

        $type = array_search($input['type'], $this->allowed_type);
        if ($type === false) {
            die('Ulovlig type i Historik->save');
        }
        $input['type'] = $type;

        if (!$this->validate($input)) {
            return 0;
        }

        $db = new DB_Sql;
        if ($this->id == 0) {
            $sql_type = "INSERT INTO historik ";
            $sql_end = ", date_created = NOW()";
        } else {
            $sql_type = "UPDATE historik ";
            $sql_end = " WHERE id = ".$this->id;
        }

        $db->query($sql_type . " SET
            date_updated = NOW(),
            type = ".$input['type'].",
            belong_to = ".$this->belong_to_key.",
            belong_to_id = ".$this->belong_to_id . ",
            comment = '".$input['comment']."',
            betaling_id = ".intval($input['betaling_id'])." "
            .$sql_end);

        if ($this->id == 0) {
            $this->id = $db->insertedId();
        }

        $this->load();
        return $this->id;
    }

    function delete()
    {
        if ($this->id == 0) {
            return 0;
        }
        $db = new DB_Sql;

        if ($this->get('betaling_id') != 0) {
            $betaling = new VIH_Model_Betaling($this->get('betaling_id'));
            $betaling->delete(); // der kontrolleres i betaling at det ikke er en dankortbetaling.
        }

        $db->query("UPDATE historik SET active = 0 WHERE id  = " . $this->id);
        return 1;
    }

    function getList()
    {
        $db = new DB_Sql;
        $historik = array();
        $db->query("SELECT id FROM historik WHERE belong_to = ".$this->belong_to_key." AND belong_to_id = " . $this->belong_to_id." AND active = 1 ORDER BY date_created");
        while($db->nextRecord()) {
            $historik[] = new VIH_Model_Historik($db->f('id'));
        }

        return $historik;
    }

    function findType($type)
    {
        $type_key = array_search($type, $this->allowed_type);
        if ($type_key === false) {
            throw new Exception('Ulovlig type i Historik->findType');
        }

        $db = new DB_Sql;
        $db->query("SELECT id FROM historik WHERE type = ".$type_key." AND belong_to = ".$this->belong_to_key." AND belong_to_id = ".$this->belong_to_id." AND active = 1");
        if ($db->nextRecord()) {
            return $db->f('id');
        } else {
            return 0;
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

}

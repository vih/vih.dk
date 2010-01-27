<?php
class VIH_Model_LangtKursus_Periode
{
    public $id;
    public $date_start;
    public $date_end;
    public $description;
    public $langtkursus_id;

    function __construct($values = array())
    {
        foreach ($values as $key => $value) {
            $this->{$key} = $value;
        }
    }

    function getId()
    {
        return $this->id;
    }

    function getDateStart()
    {
        return new Date($this->date_start);
    }

    function getDateEnd()
    {
        return new Date($this->date_end);
    }

    function getDescription()
    {
        return $this->description;
    }

    function setDateStart($date_start)
    {
        $this->date_start = $date_start;
    }

    function setDateEnd($date_end)
    {
        $this->date_end = $date_end;
    }

    function setDescription($description)
    {
        $this->description = $description;
    }
    function setId($id)
    {
        $this->id = $id;
    }

    function save($gateway)
    {
        $data = array('date_start' => $this->date_start,
                 'date_end' => $this->date_end,
                 'description' => $this->description,
                 'langtkursus_id' => $this->langtkursus_id);

        if ($this->getId() == 0) {
            $gateway->insert($data);
        } else {
            $gateway->update($data, array('id' => $this->getid()));
        }

        return true;
    }

    ///////////////////////////////////////////////////////////////

    public static function getFromId($conn, $id)
    {
        try {
            //$result = $conn->query('SELECT * FROM langtkursus_fag_periode WHERE id = ' . $conn->quote((int)$id));
            $result = $conn->query('SELECT * FROM langtkursus_fag_periode WHERE id = ' . $conn->quote((int)$id))->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw $e;
        }
        if (!empty($result[0])) {
            return new VIH_Model_LangtKursus_Periode($result[0]);
        }
        return new VIH_Model_LangtKursus_Periode();
    }

    public static function getFromKursusId($conn, $id)
    {
        try {
            //$result = $conn->query('SELECT * FROM langtkursus_fag_periode WHERE id = ' . $conn->quote((int)$id));
            $result = $conn->query('SELECT * FROM langtkursus_fag_periode
                WHERE langtkursus_id = ' . $conn->quote((int)$id) . ' ORDER BY date_start ASC, date_end DESC')->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw $e;
        }
        $array = array();

        foreach ($result as $r) {
            $array[] = new VIH_Model_LangtKursus_Periode($r);
        }

        return $array;
    }


}
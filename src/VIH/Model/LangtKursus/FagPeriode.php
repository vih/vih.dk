<?php
class VIH_Model_LangtKursus_FagPeriode
{
    private $fag;
    private $periode;

    function __construct($fag, $periode = null)
    {
        $this->fag = $fag;
        $this->periode = $periode;
    }

    function hasPeriode()
    {
        return (!empty($this->periode) AND is_object($this->periode) AND $this->periode->getId() > 0);
    }

    function getFag()
    {
        return $this->fag;
    }

    function getPeriode()
    {
        if (!$this->hasPeriode()) {
            return new VIH_Model_LangtKursus_Periode(array('id' => 0));
        }
        return $this->periode;
    }

    function getDeltagerCount($db)
    {
        if (!$this->hasPeriode()) {
            return 'n/a';
        }

        $result = $db->query('SELECT * FROM langtkursus_tilmelding_x_fag
            WHERE fag_id = ' . $this->fag->getId() . '
                AND periode_id = ' . $db->quote($this->periode->getId()));

        return count($row = $result->fetchAll());

    }


}
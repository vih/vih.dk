<?php
class VIH_Model_KortKursus_Indkvartering
{
    /**
     * @var object
     */
    protected $course;

    /**
     * @var object
     */
    protected $db;

    /**
     * @var array
     */
    protected $types = array(
        1 => 'Dobbeltværelse (bad og toilet på gangen)',
        2 => 'Enkeltværelse (toilet og bad deles med en anden)',
        3 => 'Dobbeltværelse (toilet og bad på værelset)',
        4 => 'Tremandsværelse (toilet og bad på værelset)'
    );

    /**
     * Constructor
     *
     * @param object $course
     *
     * @return void
     */
    function __construct(VIH_Model_KortKursus $course)
    {
        $this->course = $course;
        $this->db = MDB2::singleton(DB_DSN);
    }

    function flushAll()
    {
        $this->db->exec('DELETE FROM kortkursus_x_indkvartering WHERE kursus_id = ' . $this->course->getId());
    }

    /**
     * Activates places to stay for course
     *
     * @param $key
     *
     * @return boolean
     */
    function activate($key, $price)
    {
        $res = $this->db->query('SELECT id FROM kortkursus_x_indkvartering WHERE kursus_id = ' . $this->course->getId() . ' AND indkvartering_key = ' . $key);

        if (PEAR::isError($res)) {
            throw new Exception($res->getUserInfo());
        }

        if (!$res->fetchRow()) {
            $this->db->exec('INSERT INTO kortkursus_x_indkvartering SET datetime = NOW(), kursus_id = ' . $this->course->getId() . ', indkvartering_key = ' . $key . ', price = "' . $price . '"');
        } else {
            $this->db->exec('UPDATE kortkursus_x_indkvartering SET datetime = NOW(), kursus_id = ' . $this->course->getId() . ', indkvartering_key = ' . $key . ', price = "' . $price . '"');
        }
        return true;
    }

    /**
     * Returns all active stays
     *
     * @return array
     */
    function getActive()
    {
        $res = $this->db->query('SELECT id, indkvartering_key, price FROM kortkursus_x_indkvartering WHERE kursus_id = ' . $this->course->getId() . ' ORDER BY indkvartering_key ASC');

        if (PEAR::isError($res)) {
            throw new Exception($res->getUserInfo());
        }

        return $res->fetchAll(MDB2_FETCHMODE_ASSOC);
    }

    function getTypes()
    {
        return $this->types;
    }

    function getType($key)
    {
        return $this->types[$key];
    }
}
<?php
/**
 * Skrevet med tanke p� php 5 og en ordentlig database
 *
 */
class VIH_News
{
    public $kernel;
    private $id;
    private $value;
    private $db;

    /**
     * has to be public for the edit page
     *
     * @var array
     */
    public $prioritet = array(
        1 => 'høj',
        2 => 'mellem',
        3 => 'lav'
    );

    /**
     * has to be public for the edit page
     *
     * @deprecated
     *
     * @var array
     */
    public $kategori = array(
        0 => 'Nyhed',
        1 => 'Korte kurser',
        2 => 'Lange kurser',
        28 => 'Fodbold',
        31 => 'Aerobic',
        29 => 'Håndbold',
        30 => 'Badminton',
        27 => 'Volleyball',
        9 => 'Kursuscenter',
        10 => 'Elevforeningen',
        11 => 'Hjemmeside',
        12 => 'Rejselinjen',
        13 => 'Efterskole'

    );

    /**
     * has to be public for the edit page
     *
     * @deprecated
     *
     * @var array
     */
    public $type = array(
        1 => 'Pressemeddelelse',
        2 => 'Dagbog',
        3 => 'Highlight',
        5 => 'Stillingsopslag',
        6 => 'Almindelig nyhed'
    );

    /**
     * PHP5 constructor
     */
    function __construct($id = 0)
    {
        $this->id = (int)$id;
        $this->db = MDB2::singleton(DB_DSN);
        // $this->db->loadModule('Extended');
        if (PEAR::isError($this->db)) {
            trigger_error($db->getMessage(), E_USER_ERROR);
        }
        if ($this->id > 0) {
            $this->load();
        }

        // @todo this is a little hack. Should be put into the class somehow
        $this->kernel = new VIH_Intraface_Kernel();
        $this->kernel->intranet = new VIH_Intraface_Intranet();
    }

    function getKernel()
    {
    	return $this->kernel;
    }

    function getCategory()
    {
        return $this->kategori[$this->get('kategori_id')];
    }

    function getType()
    {
        return $this->type[$this->get('type_id')];
    }

    function load()
    {
        $sql = "SELECT id, overskrift, tekst, dato, date_expire, date_updated, date_publish, kategori_id, prioritet_id, type_id, title, description, keywords, active, published,
                    CONCAT(SUBSTRING_INDEX(tekst, ' ', 10), '...') AS teaser,
                    DATE_FORMAT(date_publish, '%d-%m-%Y') AS date_dk,
                    DATE_FORMAT(date_publish, '%m') AS dato_month,
                    DATE_FORMAT(date_publish, '%d') AS dato_day,
                    DATE_FORMAT(date_publish, '%Y%m%d') AS date_iso,
                    DATE_FORMAT(date_publish, '%a, %d %b %Y %T') AS date_rfc822
            FROM nyhed
            WHERE date_publish < NOW() AND nyhed.id=" . $this->id;

        $res = & $this->db->query($sql);

        $this->value = & $res->fetchRow(MDB2_FETCHMODE_ASSOC);
        if (empty($this->value['title'])) {
            $this->value['title'] = $this->value['overskrift'];
        }
        $this->value['kategori'] = $this->kategori[$this->value['kategori_id']];

        return 1;
    }

    function isPublished()
    {
        if ($this->get('date_publish') > date('Y-m-d H:i:s') AND $this->get('published')) {
            return true;
        }
        return false;
    }

    function get($key = '')
    {
        if (!empty($key)) {
            return $this->value[$key];
        }
        return $this->value;
    }

    /**
     *
     */
    function save($input)
    {
        $input = array_map('mysql_escape_string', $input);
        /*
        $fields = array(
            'date_publish',
            'date_expire',
            'overskrift',
            'tekst',
            'kategori_id',
            'prioritet',
            'title',
            'keywords',
            'description',
            'type_id'
        );
        $values = array(
            ,
            $input["date_expire"],
            $input["overskrift"],
            $input["tekst"],
            $input["kategori_id"],
            $input["prioritet_id"],
            $input["title"],
            $input["keywords"],
            $input["description"],
            $input["type_id"]
        );
        */
        if ($this->id > 0) {
            $sql = 'UPDATE ';
            $sql_where = ' WHERE id = ' . $this->id;
        } else {
            $sql = 'INSERT INTO ';
            $sql_where = ', date_created = NOW()';
        }

            //kategori_id =  '" . $input["kategori_id"] . "',
            //prioritet =  '" . $input["prioritet_id"] . "',
            // type_id =  '" . $input["type_id"] . "'"


        $sql = $sql . "nyhed SET
            date_updated = NOW(),
            date_publish =  '" . $input["date_publish"] . "',
            date_expire =  '" . $input["date_expire"] . "',
            overskrift =  '" . $input["overskrift"] . "',
            tekst =  '" . $input["tekst"] . "',
            title =  '" . $input["title"] . "',
            keywords =  '" . $input["keywords"] . "',
            description =  '" . $input["description"] . "'" . $sql_where;

        $res = $this->db->query($sql);

        if (PEAR::isError($res)) {
            trigger_error($res->getMessage(), E_USER_WARNING);
        }

        if ($this->id == 0) {
            $this->id = $this->db->lastInsertID();
        }

        return $this->id;
    }

    function delete()
    {
        $res = $this->db->query("UPDATE nyhed SET active = 0 WHERE id = " . $this->id);
        return 1;
    }

    /**
     *
     */
    function getList($cat = "", $limit = 5, $prioritet = '')
    {
        // HACK category is not used anymore after the introduction of keywords
        $cat = '';
        if (empty($cat)) {
            $sql = "SELECT id
                FROM nyhed
                WHERE  (date_expire > NOW()
                    OR date_expire = '0000-00-00 00:00:00')
                    AND active = 1 AND date_publish < NOW()
                ORDER BY date_publish DESC LIMIT " . $limit;
        } else {
            $sql = "SELECT id
                FROM nyhed nyhed
                WHERE (date_expire > NOW()
                    OR date_expire = '0000-00-00 00:00:00') AND date_publish < NOW()";
                if ($prioritet == 1) {
                    $sql .= " AND prioritet_id=1 ";
                }
                $sql .= " AND kategori_id= " . $cat . " AND active = 1
                    ORDER BY date_publish DESC  LIMIT " . $limit;
        }
        $db = MDB2::factory(DB_DSN);
        if (PEAR::isError($db)) die($db->getMessage() . $db->getUserInfo());
        $result = $db->query($sql);

        if (PEAR::isError($result)) die($result->getMessage() . $result->getUserInfo());
        $news = array();
        while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC)){
            $news[] = new VIH_News($row['id']);
        }
        return $news;
    }

    function getNewsPictures()
    {
        $sql = 'SELECT file_id, nyhed_id FROM nyhed_x_file x INNER JOIN nyhed ON nyhed.id = x.nyhed_id
                WHERE (date_expire > NOW() OR date_expire = \'0000-00-00 00:00:00\')
                    AND nyhed.date_publish < NOW()
                    AND nyhed.active = 1
                    AND nyhed.published = 1
                ORDER BY nyhed.date_publish DESC, x.id ASC LIMIT 5';
        $db = & MDB2::singleton(DB_DSN);
        $db->setFetchMode(MDB2_FETCHMODE_ASSOC);
        return ($result = $db->queryAll($sql));
    }

    function addPicture($picture_id)
    {
        if ($this->id == 0) {
            return 0;
        }
        $this->db->query("INSERT INTO nyhed_x_file SET nyhed_id = " .  $this->id . ", file_id = " . (int)$picture_id);
        return 1;
    }

    function getPictures()
    {
        if ($this->id == 0) {
            return array();
        }
        $sql = "SELECT x.file_id FROM nyhed_x_file x WHERE x.file_id > 0 AND x.nyhed_id = " .  $this->id . " ORDER BY x.id ASC";
        $this->db->setFetchMode(MDB2_FETCHMODE_ASSOC);
        return ($result = $this->db->queryAll($sql));
        /*
        $pics = array();
        forea ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC)) {
            $pics[] = $row['file_id'];
        }
        return $pics;
        */
    }

    function deletePicture($picture_id)
    {
        if ($this->id == 0) {
            return 0;
        }
        $this->db->query("DELETE FROM nyhed_x_file WHERE nyhed_id = " .  $this->id . " AND file_id = " . (int)$picture_id);
    }

    function getId()
    {
        return $this->id;
    }
}

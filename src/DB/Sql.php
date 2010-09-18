<?php
/**
 * This is an old PHP4 database abstraction class. It has be rewritten to use
 * a singleton of PEARs MDB2.
 */
require_once 'MDB2.php';

class DB_Sql
{
    var $db;
    var $row;
    var $result;

    function DB_Sql($dbhost = '', $dbuser = '', $dbpass = '', $dbname = '')
    {
        if (empty($dbhost) OR empty($dbuser) OR empty($dbpass) OR empty($dbname)) {
            $this->db = MDB2::singleton(DB_DSN);
        } else {
            $this->db = MDB2::singleton('mysql://' . $dbuser . ':' . $dbpass . '@' . $dbhost . '/' . $dbname);
        }

        if (PEAR::isError($this->db)) {
            die($this->db->getMessage() . ' ' . $this->db->getUserInfo());
        }
        $this->db->query('SET NAMES utf8');
    }

    function query($SQL)
    {
        $this->result = $this->db->query($SQL);
        if (PEAR::isError($this->result)) {
            die($this->result->getMessage() . ' ' . $this->result->getUserInfo());
        }
    }

    function exec($SQL)
    {
        $this->result = $this->db->exec($SQL);
        if (PEAR::isError($this->result)) {
            die($this->result->getMessage() . ' ' . $this->result->getUserInfo());
        }

        $this->result->free();
    }

    function nextRecord()
    {
        $this->row = $this->result->fetchRow(MDB2_FETCHMODE_ASSOC);
        if (PEAR::isError($this->row)) {
            die($this->row->getMessage() . '' . $this->row->getUserInfo());
        }

        return($this->row);
    }

    function affectedRows()
    {
        return($this->db->_affectedRows(NULL));
    }

    function f($name)
    {
        return($this->row[$name]);
    }

    function free()
    {
        $this->result->free();
    }

    function insertedId()
    {
        return($this->db->lastInsertID());
    }

    function numRows()
    {
        return($this->result->numRows());
    }

    function escape($value)
    {
        return mysql_escape_string($value);
    }

    function quote($value, $type)
    {
        return $this->db->quote($value, $type);
    }
}
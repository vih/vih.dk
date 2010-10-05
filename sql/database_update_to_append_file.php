<?php
/**
 * This files is used to update AppendFiles
 */

/**
 * register types
 * 0: _invalid_
 * 1: ansat
 * 2: facilitet
 * 3: dokumenter
 * 4: kortkursus
 * 5: langtkursus_fag
 */


die('Only wise man know...');

require_once('config.local.php');
require_once 'MDB2.php';


$db = MDB2::factory(DB_DSN);

if (PEAR::isError($db)) {
    throw new Exception($db->getUserInfo());
    exit;
}

// ansat 1
$result = $db->query('SELECT id, pic_id FROM ansat');
if (PEAR::isError($result)) {
    throw new Exception($result->getUserInfo());
    exit;
}
while($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC)) {
    if ($row['pic_id'] != 0) {
        $insert = $db->exec('INSERT INTO filehandler_append_file SET ' .
                'date_created = NOW(), ' .
                'date_updated = NOW(), ' .
                'belong_to_key = 1,' .
                'belong_to_id = '.intval($row['id']).', ' .
                'file_handler_id = '.intval($row['pic_id']).'');
        if (PEAR::isError($insert)) {
            throw new Exception($insert->getUserInfo());
            exit;
        }
    }
}

// facilitet 2
$result = $db->query('SELECT id, pic_id FROM facilitet');
if (PEAR::isError($result)) {
    throw new Exception($result->getUserInfo());
    exit;
}
while($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC)) {
    if ($row['pic_id'] != 0) {
        $insert = $db->exec('INSERT INTO filehandler_append_file SET ' .
                'date_created = NOW(), ' .
                'date_updated = NOW(), ' .
                'belong_to_key = 2,' .
                'belong_to_id = '.intval($row['id']).', ' .
                'file_handler_id = '.intval($row['pic_id']).'');
        if (PEAR::isError($insert)) {
            throw new Exception($insert->getUserInfo());
            exit;
        }
    }
}

// dokumenter 3
$result = $db->query('SELECT id, file_id FROM dokumenter');
if (PEAR::isError($result)) {
    throw new Exception($result->getUserInfo());
    exit;
}
while($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC)) {
    if ($row['file_id'] != 0) {
        $insert = $db->exec('INSERT INTO filehandler_append_file SET ' .
                'date_created = NOW(), ' .
                'date_updated = NOW(), ' .
                'belong_to_key = 3,' .
                'belong_to_id = '.intval($row['id']).', ' .
                'file_handler_id = '.intval($row['pic_id']).'');
        if (PEAR::isError($insert)) {
            throw new Exception($insert->getUserInfo());
            exit;
        }
    }
}

// kortkursus 4
$result = $db->query('SELECT id, pic_id FROM kortkursus');
if (PEAR::isError($result)) {
    throw new Exception($result->getUserInfo());
    exit;
}
while($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC)) {
    if ($row['pic_id'] != 0) {
        $insert = $db->exec('INSERT INTO filehandler_append_file SET ' .
                'date_created = NOW(), ' .
                'date_updated = NOW(), ' .
                'belong_to_key = 4,' .
                'belong_to_id = '.intval($row['id']).', ' .
                'file_handler_id = '.intval($row['pic_id']).'');
        if (PEAR::isError($insert)) {
            throw new Exception($insert->getUserInfo());
            exit;
        }
    }
}

// kortkursus_tilmelding ? 
// kunst ? (har varchar billede)

// langtkursus_fag 5
$result = $db->query('SELECT id, pic_id FROM langtkursus_fag');
if (PEAR::isError($result)) {
    throw new Exception($result->getUserInfo());
    exit;
}
while($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC)) {
    if ($row['pic_id'] != 0) {
        $insert = $db->exec('INSERT INTO filehandler_append_file SET ' .
                'date_created = NOW(), ' .
                'date_updated = NOW(), ' .
                'belong_to_key = 5,' .
                'belong_to_id = '.intval($row['id']).', ' .
                'file_handler_id = '.intval($row['pic_id']).'');
        if (PEAR::isError($insert)) {
            throw new Exception($insert->getUserInfo());
            exit;
        }
    }
}

// langtkursus_tilmelding ? 


?>

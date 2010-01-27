<?php
set_include_path('/home/vih/pear/php/' . PATH_SEPARATOR . get_include_path());

require_once dirname(__FILE__) . '/include_elevforeningen.php';

/* TEMP HACK SENDING TO LOGIN */
if(!empty($_GET['code'])) {
	header('location: login.php?handle='.$_GET['code']);
	exit;
}
/* HACK END */

require_once 'MDB2.php';
require_once 'HTML/QuickForm.php';
require_once 'IntrafacePublic/Contact/XMLRPC/Client.php';
require_once 'IntrafacePublic/Debtor/XMLRPC/Client.php';
require_once 'IntrafacePublic/Shop/XMLRPC/Client.php';

session_start();

$credentials = array('private_key' => 'L9FtAdfAu8QwLSChGZehzeZwiAhXNwsqwWIMZF4avCw6jY6HN2G', 'session_id' => md5(session_id()));

define('DB_DSN', 'mysql://vih:qdq65txp@mysql.vih.dk/vih');
define('PATH_ROOT', '/home/vih/');


function is_jubilar($auth) {
    $jubilar = false;
    $db = MDB2::factory(DB_DSN);
    $jubilar_aargange = array();
    $result = $db->query("SELECT aargange FROM elevforeningen_jubilar ORDER BY id DESC");
    if ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC)){
        $jubilar_aargange = array_values(unserialize($row['aargange']));
    }

    $keywords = $auth->getConnectedKeywords((int)$_SESSION['contact_id']);
    $jubilar = false;

    if (is_array($keywords)) {
        foreach ($keywords as $key => $value) {
            if (in_array($value['id'], $jubilar_aargange)) {
                $jubilar = true;
            }
        }
    }
    return $jubilar;
}

function utf8_decoding($string) {
    if (is_array($string)) {
        return array_map('utf8_decoding', $string);
    }
    if (is_object($string)) {
    	return $string->local;
    }
    return utf8_decode($string);
}

/*
session_start();
*/
/*

$lu_config = array(
    'autoInit' => true,
    'login' => array(
        'force'    => true,
        'regenid'  => true
    ),
    'authContainers' => array(
        'members' => array(
            'type'            => 'DB',
            'loginTimeout'    => 0,
            'expireTime'      => 3600,
            'idleTime'        => 1800,
            'updateLastLogin' => false,
            'passwordEncryptionMode' => 'PLAIN',
            'allowDuplicateHandles' => false,
            'allowEmptyPasswords'   => false,
            'storage' => array(
                'dsn' => DB_DNS,
                'prefix' => '',
                'alias' => array(
                    'users' => 'elevforeningen_medlemskartotek',
                    'auth_user_id' => 'id',
                    'is_active' => 'active',
                    'handle' => 'code',
                    'passwd' => 'code')
        )

    )

));

$usr =& LiveUser::factory($lu_config);
$usr->init();

if ($usr->isInactive()) {
    trigger_error('Brugeren p� dette medlemsnummer er ikke aktiv. Skriv til lars@vih.dk, hvis du mener, at det er en fejl.', E_USER_ERROR);
}
elseif (!$usr->isLoggedIn() AND basename($_SERVER['PHP_SELF']) != 'login.php') {
    header('Location: login.php');
    exit;
}
*/


$auth = new IntrafacePublic_Contact_XMLRPC_Client($credentials, false);

if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

?>

<?php
require('../config.elevforeningen.php');
//require('LiveUser/LiveUser.php');
require('HTML/QuickForm.php');
//require('DB.php');
//require(PATH_INCLUDE_VIH . 'elevforeningen/Medlem.php');

require(dirname(__FILE__) . '/Auth.php');
require(dirname(__FILE__) . '/DebtorClient.php');
require(dirname(__FILE__) . '/ContactClient.php');
require(dirname(__FILE__) . '/WebshopClient.php');
require(dirname(__FILE__) . '/Template/Template.php');
require('MDB2.php');

function e($phrase)
{
	echo htmlentities($phrase);
}

function __($phrase)
{
	return $phrase;
}

function url($phrase)
{
    return $phrase;
}

// get_secure_server();

define('PATH_TEMPLATE_KUNDELOGIN', dirname(__FILE__) . '/View/Kundelogin/');
define('PATH_TEMPLATE', dirname(__FILE__) . '/View/Kundelogin/');

$private_key = 'L9FtAdfAu8QwLSChGZehzeZwiAhXNwsqwWIMZF4avCw6jY6HN2G';

define('INTRAFACE_PRIVATE_KEY', $private_key);

function _is_jubilar($auth) {
	$jubilar = false;
	$db = new DB_Sql;
	$db->query("SELECT aargange FROM elevforeningen_jubilar ORDER BY id DESC");
	if ($db->nextRecord()){
		$jubilar_aargange = array_values(unserialize($db->f('aargange')));
	}

	$contact = $auth->get();
	$keywords = $auth->contact_client->getConnectedKeywords($contact['id']);
	$jubilar = false;

	if (is_array($keywords)) {
		foreach ($keywords AS $key => $value) {
			if (in_array($value, $jubilar_aargange)) {
				$jubilar = true;
			}
		}
	}
	return $jubilar;
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
	trigger_error('Brugeren på dette medlemsnummer er ikke aktiv. Skriv til lars@vih.dk, hvis du mener, at det er en fejl.', E_USER_ERROR);
}
elseif (!$usr->isLoggedIn() AND basename($_SERVER['PHP_SELF']) != 'login.php') {
	header('Location: login.php');
	exit;
}
*/
?>

<?php
error_reporting(E_ALL &~E_DEPRECATED);

define('DB_HOST', 'localhost');
define('DB_NAME', 'vih');
define('DB_PASSWORD', '');
define('DB_PASS', DB_PASSWORD);
define('DB_USER', 'root');
define('DB_DSN', 'mysql://' . DB_USER . ':' . DB_PASSWORD . '@' . DB_HOST . '/' . DB_NAME);

define('PATH_ROOT', '');
define('PATH_WWW', '');

set_include_path(dirname(__FILE__) . '/../../src/' . PATH_SEPARATOR . get_include_path());

require_once 'Ilib/ClassLoader.php';
require_once 'VIH/configuration.php';
require_once 'Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));

Doctrine_Manager::connection(DB_DSN);
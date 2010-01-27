<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'vih');
define('DB_PASSWORD', '');
define('DB_PASS', '');
define('DB_USER', 'root');
define('DB_DSN', 'mysql://' . DB_USER . ':' . DB_PASSWORD . '@' . DB_HOST . '/' . DB_NAME);

define('PATH_ROOT', '');
define('PATH_WWW', '');

set_include_path('c:/Users/Lars Olesen/workspace/vih/hojskole/src/' . PATH_SEPARATOR . get_include_path());

require_once 'Ilib/ClassLoader.php';
require_once 'VIH/configuration.php';
require_once 'Doctrine/lib/Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));
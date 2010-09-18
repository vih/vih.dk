<?php
define('PATH_ROOT',      dirname(__FILE__) . '/../../');
define('PATH_INCLUDE',   '/home/lsolesen/workspace/ilib/3Party/Ilib_Keyword/src/' . PATH_SEPARATOR . '/home/lsolesen/workspace/ilib/3Party/Ilib_DBQuery/src/' . PATH_SEPARATOR . '.' . PATH_SEPARATOR . PATH_ROOT . PATH_SEPARATOR . get_include_path());
define('PATH_WWW',       'http://localhost/vih/hojskole/src/vih.dk/');
define('DB_USER',        'root');
define('DB_PASSWORD',    'xxx');
define('DB_NAME',        'vih');
define('DB_HOST',        'localhost');
define('DB_DSN',         'mysql://' . DB_USER . ':' . DB_PASSWORD . '@' . DB_HOST . '/' . DB_NAME);
define('SECURE_SERVER_STATUS',    'offline');
define('PATH_UPLOAD', '/home/lsolesen/workspace/vih_upload/');
define('PATH_UPLOAD_ORIGINAL', PATH_UPLOAD . 'devel/original/');
define('PATH_UPLOAD_INSTANCE', PATH_UPLOAD . 'devel/instance/');
define('PATH_UPLOAD_TEMPORARY', 'temp/');
define('IMAGE_POPUP_SIZE', 'medium');
define('FILE_VIEWER', '/hojskole/src/vih.dk/file.php');

set_include_path(PATH_INCLUDE);

error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);

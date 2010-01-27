<?php
// paths
if (!defined('PATH_ROOT')) { define('PATH_ROOT', dirname(__FILE__) . '/../'); }

define('PATH_CACHE', PATH_ROOT . 'cache/');
if (!defined('PATH_UPLOAD_ORIGINAL')) { define('PATH_UPLOAD_ORIGINAL', PATH_ROOT . 'upload/devel/original/'); }
if (!defined('PATH_UPLOAD_INSTANCE')) { define('PATH_UPLOAD_INSTANCE', PATH_ROOT . 'upload/devel/instance/'); }
if (!defined('PATH_UPLOAD_TEMPORARY')) { define('PATH_UPLOAD_TEMPORARY', 'tmp/'); }

// hosts
if (!defined('SECURE_HOST')) { define('SECURE_HOST', 'https://vih.dk'); }
if (!defined('HOST')) { define('HOST', 'http://vih.dk'); }
if (!defined('PATH_WWW')) { define('PATH_WWW', 'http://vih.dk'); }

// database
if (!defined('DB_HOST')) { define('DB_HOST', 'localhost'); }
if (!defined('DB_USER')) { define('DB_USER', 'root'); }
if (!defined('DB_PASSWORD')) { define('DB_PASSWORD', ''); }
if (!defined('DB_NAME')) { define('DB_NAME', 'vih'); }
if (!defined('DB_DSN')) { define('DB_DSN', 'mysql://'.DB_USER.':'.DB_PASSWORD.'@'.DB_HOST.'/'.DB_NAME.''); }

// sikkerhedsindstillinger
define('SECRET_KEY', 'klumpedumpe');
if (!defined('SECURE_SERVER_STATUS')) { define('SECURE_SERVER_STATUS', 'online'); }

// online stuff
if (!defined('EMAIL_STATUS')) { define('EMAIL_STATUS', 'online'); }

// Standards
define('VIH_NAVN', 'Vejle Idrætshøjskole');
define('VIH_EMAIL', 'kontor@vih.dk');
define('VIH_KONTAKTANSVARLIG', 'Peter Sebastian Pedersen');
define('VIH_KONTAKTANSVARLIG_EMAIL', 'elev@vih.dk');

// Korte kurser
define('KORTEKURSER_TILMELDING_STATUS', 'online');
define('KORTEKURSER_STANDARDPRISER_DEPOSITUM', 1000);
define('KORTEKURSER_STANDARDPRISER_AFBESTILLINGSFORSIKRING', 250);
define('KORTEKURSER_GOLF_BEGYNDERPLADSER', 10);
define('KORTEKURSER_GOLF_BEGYNDERHANDICAP', 50);
define('KORTEKURSER_STATUS_FAA_LEDIGE_PLADSER', 6);
define('KORTEKURSER_STATUS_UDSOLGT', 0);
define('KORTEKURSER_LOGIN_URI', HOST . PATH_WWW . 'login/kortekurser/');

// Lange kurser
define('LANGEKURSER_TILMELDING_STATUS', 'online');
define('LANGEKURSER_STANDARDPRISER_TILMELDINGSGEBYR', 1000);
define('LANGEKURSER_LOGIN_URI', HOST . PATH_WWW . 'login/langekurser/');


// Intrafaceindstillinger
define('NEWSLETTER_EMAIL_LIST', 14); // indstilling til nyhedsbrev
define('NEWSLETTER_EMAIL_LIST_ELEVFORENINGEN', 16);
define('NEWSLETTER_EMAIL_LIST_KURSUSCENTER', 17);

// Quickpay - betalingsgateway
define('ONLINEBETALING_STATUS', 'online');
define('QUICKPAY_MERCHANT_ID', '36850728');
define('QUICKPAY_MD5_SECRET', 'FSfTW75Ghgl8MKprD5c9zewv92L86jU916Y53XRaQ1qnV7821xbd9INZ428mk4Bt');

// filehandler
if (!defined('IMAGE_POPUP_SIZE')) { define('IMAGE_POPUP_SIZE', 'medium'); }
define('IMAGE_LIBRARY', 'GD');

ini_set('session.use_trans_sid', '0');

putenv('TZ=Europe/Copenhagen');
setlocale(LC_ALL, 'da_DK.ISO8859-1');
<?php
require_once 'config.local.php';

set_include_path(PATH_INCLUDE);

require_once 'VIH.php';
require_once 'Ilib/ClassLoader.php';
require_once 'Doctrine/lib/Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));

require_once 'VIH/errorhandler.php';
set_error_handler('vih_error_handler');

$application = new VIH_Root();

$application->registry->registerConstructor('newsletter', create_function(
  '$className, $args, $registry',
  '$credentials = array("private_key" => INTRAFACE_PRIVATE_KEY,
                        "session_id"  => $registry->SESSION->getSessionId());
   XML_RPC2_Backend::setBackend("php");
   return new IntrafacePublic_Newsletter_XMLRPC_Client($credentials);'
));

$application->registry->registerConstructor('database', create_function(
  '$className, $args, $registry',
  'return new pdoext_Connection("mysql:dbname=" . DB_NAME . ";host=" . DB_HOST, DB_USER, DB_PASSWORD);'
));

$application->registry->registerConstructor('database:mdb2', create_function(
  '$className, $args, $registry',
  '$options= array("debug" => 2);
   $db = MDB2::factory(DB_DSN, $options);
   if (PEAR::isError($db)) {
        throw new Exception($db->getMessage());
   }
   $db->setOption("portability", MDB2_PORTABILITY_NONE);
   $db->setFetchMode(MDB2_FETCHMODE_ASSOC);
   $db->exec("SET time_zone=\"-01:00\"");
   return $db;
'
));

$application->registry->registerConstructor('doctrine', create_function(
  '$className, $args, $registry',
  '$conn = Doctrine_Manager::connection(DB_DSN);
   Doctrine_Manager::getInstance()->setAttribute("model_loading", "conservative");
   return $conn;
  '
));

$application->registry->registerConstructor('intraface:kernel', create_function(
  '$className, $args, $registry',
  '$kernel = new VIH_Intraface_Kernel;
   $kernel->setting = new VIH_Intraface_Setting;
   $kernel->intranet = new VIH_Intraface_Intranet;
   $kernel->user = new VIH_Intraface_User;
   return $kernel;
  '
));

try {
    $application->dispatch();
} catch (Exception $e) {
    vih_error_handler($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTrace());
}
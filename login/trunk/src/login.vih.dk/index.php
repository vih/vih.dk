<?php
require_once 'config.local.php';

set_include_path(PATH_INCLUDE);

require_once 'VIH.php';
require_once 'VIH/errorhandler.php';
set_error_handler('vih_error_handler');

require_once 'Ilib/ClassLoader.php';

$application = new VIH_Controller_Login_Root();

$application->registry->registerConstructor('doctrine', create_function(
  '$className, $args, $registry',
  '$conn = Doctrine_Manager::connection(DB_DSN);
   Doctrine_Manager::getInstance()->setAttribute("model_loading", "conservative");
   return $conn;
  '
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

try {
    $application->dispatch();
} catch (Exception $e) {
    vih_error_handler($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTrace());
}

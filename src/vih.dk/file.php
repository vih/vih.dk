<?php
/**
 * Denne fil bruges til at tilg� filerne.
 *
 * hvordan f�r vi puttet den her under unittests?
 *
 * @author Sune Jensen <sj@sunet.dk>
 * @author Lars Olesen <lars@legestue.net>
 */

require_once 'config.local.php';
require_once 'Ilib/ClassLoader.php';

// file should stop if no querystring
if (empty($_SERVER["QUERY_STRING"])) {
    trigger_error('no querystring is given!', E_USER_WARNING);
    exit;
}
$query_parts = explode('/', $_SERVER["QUERY_STRING"]);
$kernel = new VIH_Intraface_Kernel;
$kernel->intranet = new VIH_Intraface_Intranet(0);

$filehandler = Ilib_Filehandler::factory($kernel, $query_parts[2]);
if(!is_object($filehandler) || $filehandler->getId() == 0) {
    trigger_error('Invalid image: '.$_SERVER['QUERY_STRING'], E_USER_WARNING);
    exit;
}

settype($query_parts[3], 'string');
$fileviewer = new Ilib_Filehandler_FileViewer($filehandler, $query_parts[3]);
$fileviewer->out();
exit;
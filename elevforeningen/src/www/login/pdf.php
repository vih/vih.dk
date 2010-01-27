<?php
/**
 * Der kan ikke v�re sp�rring p� denne fil, for det kan IE ikke h�ndtere
 * over en sikker server.
 *
 */

if (empty($_GET['id']) OR !is_numeric($_GET['id'])) {
    trigger_error('Du kan kun åbne denne side, når der er et id', E_USER_ERROR);
    exit;
}

require('include_elevforeningen_login.php');

$debtor_client = new IntrafacePublic_Debtor_XMLRPC_Client($credentials, false);
$pdf = $debtor_client->pdf($_GET['id']);
//$pdf = $debtor_client->get($_GET['id']);
//$pdf = $debtor_client->getList('order', $contact_array['id']);


header('Content-type: application/pdf');
header("Content-Length: ".strlen(ltrim($pdf)));
header("Content-Disposition: inline; filename=file.php");

echo ltrim($pdf);

?>
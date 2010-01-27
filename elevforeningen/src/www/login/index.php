<?php
require 'include_elevforeningen_login.php';

$contact_array = $auth->getContact($_SESSION['contact_id']);
$debtor_client = new IntrafacePublic_Debtor_XMLRPC_Client($credentials, false);
$orders = $debtor_client->getDebtorList('order', $contact_array['id']);
$invoices = $debtor_client->getDebtorList('invoice', $contact_array['id']);

//$debtors = array_merge($orders, $invoices);

/*
if (count($debtors) > 0) {
    // Fremstiller en liste af koloner
    foreach ($debtors as $key => $row) {
       $date[$key]  = $row['this_date'];
    //   $edition[$key] = $row['edition'];
    }

    // Sorterer 'volume' data faldende og 'edition' stigende
    // Tilfï¿½jer $data som den sidste parameter sï¿½ sorteringen sker direkte
    // i det array.
    array_multisort($date, SORT_DESC, $debtors);
}
*/
//$debtors = array_merge($orders, $invoices);

//print_r($orders);

/*
$contact = new ContactClient(array('private_key' => $private_key), true);
$contact_array = $contact->factory('code', $_GET['password']);
$contact_array = $contact->factory('email', 'lars@legestue.net');
*/
/*
if (!empty($contact_array['id']) AND $contact_array['id'] > 0) {
    $contact->sendLoginEmail($contact_array['id']);
}
*/


$tpl = new Template(PATH_TEMPLATE_KUNDELOGIN);
$tpl->set('title', 'Kontakt');

$headline = 'Elevstævne';

$string = '
    <p><a href="tilmelding.php">Tilmelding &rarr;</a></p>
';

if (count($invoices) > 0) {
    $debtor_tpl = new Template(PATH_TEMPLATE);
    $debtor_tpl->set('caption', 'Accepterede tilmeldinger');
    $debtor_tpl->set('debtors', utf8_decoding($invoices));
    $debtor_tpl->set('credentials', $credentials);
    $string .= $debtor_tpl->fetch('elevforeningen/debtors-tpl.php');
}
if (count($orders) > 0) {
    $debtor_tpl = new Template(PATH_TEMPLATE);
    $debtor_tpl->set('caption', 'Afventende tilmeldinger');
    $debtor_tpl->set('debtors', utf8_decoding($orders));
    $debtor_tpl->set('credentials', $credentials);
    $string .= $debtor_tpl->fetch('elevforeningen/debtors-tpl.php');
}

if (is_jubilar($auth)) {
    $headline .= ' og jubilæum';
}


/*
$string = '
    <p><a href="bestilling.php">Bestilling af ï¿½rsskrift &rarr;</a></p>
';
*/

if (is_array($debtors) AND count($debtors) > 0) {
    $debtor_tpl = new Template(PATH_TEMPLATE);
    $debtor_tpl->set('caption', 'Bestillinger og fakturaer');
    $debtor_tpl->set('debtors', $debtors);

    $string .= $debtor_tpl->fetch('elevforeningen/debtors-tpl.php');
}


$contact_tpl = new Template(PATH_TEMPLATE);
$contact_tpl->set('caption', 'Kontakt');
$contact_tpl->set('contact', utf8_decoding($contact_array));

$tpl->set('content_main', '
    <h1>Velkommen</h1>
    ' . $contact_tpl->fetch('elevforeningen/medlem-tpl.php') . '
    <h2>'.$headline.'</h2>
    '.$string.'
    ');

echo $tpl->fetch('main-tpl.php');
/*

    <h2>Tilmelding til '.$extra_headline.'elevmï¿½de 2006</h2>
    <p>Husk at skrive din kvittering for tilmeldingen ud og tag den med pï¿½ hï¿½jskolen. Den er fï¿½rst rigtig gï¿½ldende, nï¿½r vi har registreret din betaling.</p>
*/
?>

<?php
require 'include_elevforeningen_login.php';

$contact = $auth->getContact($_SESSION['contact_id']);

if (!empty($_GET['order_id']) AND is_numeric($_GET['order_id'])) {

    $debtor_client = new IntrafacePublic_Debtor_XMLRPC_Client($credentials, false);
    $debtor = $debtor_client->getDebtor($_GET['order_id']);

    $_SESSION['order_id'] = $debtor['id'];
    $_SESSION['amount'] = $debtor['total'];
}


if ($_SESSION['amount'] > 0) {
    $kr = number_format($_SESSION['amount'], 0, ',', '.') . ' kroner';
    $onlinebetaling = '<dt>Betaling med Dankort</dt>
        <dd>Du kan også betale med <span class="dankort">Dankort</span>. <a href="https://vih.dk/elevforeningen/login/onlinebetaling.php">Betal online &rarr;</a>.</dd>
';
}
else {
    $kr = 'pengene';
    $onlinebetaling = '';
}


$tpl = new Template(PATH_TEMPLATE_KUNDELOGIN);
$tpl->set('title', 'Betaling');
$tpl->set('description', '');
$tpl->set('keywords', '');
$tpl->set('content_main', '
    <h1>Betaling</h1>
    <dl>
        '.$onlinebetaling.'
        <dt>Betaling med kontooverførsel</dt>

        <dd>Du kan betale ved at overføre '.$kr.' til vores konto i BG Bank.<br />Registreringsnummer: 1551<br />Kontonummer: 8041970<br /><strong>HUSK</strong>: Skriv medlemsnummer ('.$contact['number'].') og ordrenummer på overførslen</dd>
    </dl>
');

echo $tpl->fetch('main-tpl.php');
?>
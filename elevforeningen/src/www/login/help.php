<?php
require 'include_elevforeningen_login.php';

$contact = $auth->getContact($_SESSION['contact_id']);

$tpl = new Template(PATH_TEMPLATE_KUNDELOGIN);
$tpl->set('title', 'Hjælp');
$tpl->set('description', '');
$tpl->set('keywords', '');
$tpl->set('content_main', '
    <h1>Hjælp</h1>
    <p>Her vil vi forsøge at hjælpe så godt vi kan. Vi har dog overhovedet ikke fået nogen spørgsmål af opklarende art endnu, så vi ved ikke helt hvad vi skal skrive :).</p>
    <h2>Kontakt</h2>
    <dl>
        <dt>Spørgsmål til elevforeningen</dt>
        <dd>Hvis du har spørgsmål om dit medlemsskab eller arrangementer, skal du skrive til elevforeningen@vih.dk.</dd>
        <dt>Spørgsmål til systemet</dt>
        <dd>Hvis du har spørgsmål til systemet, skal du skrive til lars@vih.dk.</dd>
    </dl>
');

echo $tpl->fetch('main-tpl.php');
?>
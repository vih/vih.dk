<?php
require 'include_elevforeningen_login.php';

$contact = $auth->getContact($_SESSION['contact_id']);

$tpl = new Template(PATH_TEMPLATE_KUNDELOGIN);
$tpl->set('title', 'Hj�lp');
$tpl->set('description', '');
$tpl->set('keywords', '');
$tpl->set('content_main', '
    <h1>Hj�lp</h1>
    <p>Her vil vi fors�ge at hj�lpe s� godt vi kan. Vi har dog overhovedet ikke f�et nogen sp�rgsm�l af opklarende art endnu, s� vi ved ikke helt hvad vi skal skrive :).</p>
    <h2>Kontakt</h2>
    <dl>
        <dt>Sp�rgsm�l til elevforeningen</dt>
        <dd>Hvis du har sp�rgsm�l om dit medlemsskab eller arrangementer, skal du skrive til elevforeningen@vih.dk.</dd>
        <dt>Sp�rgsm�l til systemet</dt>
        <dd>Hvis du har sp�rgsm�l til systemet, skal du skrive til lars@vih.dk.</dd>
    </dl>
');

echo $tpl->fetch('main-tpl.php');
?>
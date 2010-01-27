<?php
require 'include_kursuscenter.php';

$title = 'Kursuscenteret på Vejle Idrætshøjskole - Kontaktinformation';
$meta = array(
    'description' => 'Kontaktinformation og åbningstider til kursuscenteret på Vejle Idrætshøjskole.',
    'keywords' => 'kursuscenter, kontakt, Vejle, epost, email, e-post'
);

$tpl = new VIH_Frontend_Kursuscenter();
$tpl->set('title', $title);
$tpl->set('meta', $meta);

$tpl->set('content_main', '

<img src="images/globen_sh.jpg" width="250" height="155" alt="" />

<h1>Kontakt</h1>

<table summary="Kontaktinformation" id="kontaktinformation">
    <tr class="vcard">
        <th>Adresse</th>
        <td class="adr">
            <span>Vejle Idrætshøjskole Kursuscenter</span><br />
            <span class="street-address">Ørnebjergvej 28</span><br />
            <span class="postal-code">7100</span> <span class="locality">Vejle</span>
        </td>
    </tr>
    <tr class="vcard">
        <th>Booking</th>
        <td>
            <span class="fn">Søs Pedersen</span><br />
            <span class="tel">7572 6900</span><br />
            <span class="email">kursuscenter@vih.dk</span>
        </td>
    </tr>
    <tr>
        <th>Fax</th>
        <td>7582 0680</td>
    </tr>
    <tr class="vcard">
        <th>E-mail</th>
        <td class="email">kursuscenter@vih.dk</td>
    </tr>
    <tr>
        <th>Kontortid</th>
        <td>
            Telefonen er åben mandag til fredag 9.00-12.00
            <br />Vi opfordrer dig til først at kontakte os elektronisk på kursuscenter@vih.dk.
        </td>
    </tr>
</table>

');

$tpl->display('main-tpl.php');
?>
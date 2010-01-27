<?php
require 'include_kursuscenter.php';

$title = 'Kursuscenteret på Vejle Idrætshøjskole - Værd at vide om produkter';
$meta['description'] = '';
$meta['keywords'] = 'kursuscenter, produkter';

$tpl = new VIH_Frontend_Kursuscenter();
$tpl->set('title', 'Kursuscenter');
$tpl->set('meta', $meta);

$tpl->set('content_main', '
<h1>Produkter</h1>

<table summary="Priser for at leje værelser på Vejle Idrætshøjskole">
<caption>Priser og beskrivelser af produkter</caption>
<tr>
        <th>Fyraftensmøde</th>
        <td>
            <p>Har I brug for et sted at holde fyraftensmøder, så har vi det ideelle sted.</p>
            <ul>
                <li>Globen med plads til 157 personer med alle tænkelige tekniske hjælpemidler</li>
                <li>Pris: 3300 kroner for 3 timer. Hertil kommer forplejning og drikkevarer</li>
            </ul>

            <h3>Forplejning</h3>
            <ul>
                <li>Italiensk bolle med pålæg eller ost; 1 øl eller vand: 70,-</li>
                <li>Luksussandwich med salat; 1 øl eller vand: 70,-</li>
                <li>Osteanretning med 2 glas rødvin. Udvalg af ostespecialiteter med hjemmebagt brød, smør og ostetilbehør: 106,-</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>Dagskursus</th>
        <td>
            375,- kr. pr. person fra 9.00 - 16.00.
            <br />Indeholder formiddagskaffe/te med rundstykke, et varmt frokostmåltid, eftermiddagskaffe/te med kage og isvand.
        </td>
    </tr>
    <tr>
        <th>Kursusdøgn</th>
        <td>
            <p>Indkvartering på enkeltværelse fra 10.00 til 9.00 næste dag, hvor toilet og bad deles med en person
            <br />1056,- kr. pr. person</p>
            <p>Indeholder morgenmad, et varmt frokostmåltid, buffet til aftensmad og diverse mellemmåltider i løbet af dagen. Fri frugt, kaffe og te. Desuden er lokaleleje er inkluderet i prisen.</p>
        </td>
    </tr>
</table>

<p>Du er meget velkommen til at <a href="kontakt.php">ringe til os</a>, hvis du har forespørgsler på skræddersyede arrangementer.</p>
');

$tpl->display('main-tpl.php');
?>

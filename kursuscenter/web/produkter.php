<?php
require 'include_kursuscenter.php';

$title = 'Kursuscenteret p� Vejle Idr�tsh�jskole - V�rd at vide om produkter';
$meta['description'] = '';
$meta['keywords'] = 'kursuscenter, produkter';

$tpl = new VIH_Frontend_Kursuscenter();
$tpl->set('title', 'Kursuscenter');
$tpl->set('meta', $meta);

$tpl->set('content_main', '
<h1>Produkter</h1>

<table summary="Priser for at leje v�relser p� Vejle Idr�tsh�jskole">
<caption>Priser og beskrivelser af produkter</caption>
<tr>
        <th>Fyraftensm�de</th>
        <td>
            <p>Har I brug for et sted at holde fyraftensm�der, s� har vi det ideelle sted.</p>
            <ul>
                <li>Globen med plads til 157 personer med alle t�nkelige tekniske hj�lpemidler</li>
                <li>Pris: 3300 kroner for 3 timer. Hertil kommer forplejning og drikkevarer</li>
            </ul>

            <h3>Forplejning</h3>
            <ul>
                <li>Italiensk bolle med p�l�g eller ost; 1 �l eller vand: 70,-</li>
                <li>Luksussandwich med salat; 1 �l eller vand: 70,-</li>
                <li>Osteanretning med 2 glas r�dvin. Udvalg af ostespecialiteter med hjemmebagt br�d, sm�r og ostetilbeh�r: 106,-</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>Dagskursus</th>
        <td>
            375,- kr. pr. person fra 9.00 - 16.00.
            <br />Indeholder formiddagskaffe/te med rundstykke, et varmt frokostm�ltid, eftermiddagskaffe/te med kage og isvand.
        </td>
    </tr>
    <tr>
        <th>Kursusd�gn</th>
        <td>
            <p>Indkvartering p� enkeltv�relse fra 10.00 til 9.00 n�ste dag, hvor toilet og bad deles med en person
            <br />1056,- kr. pr. person</p>
            <p>Indeholder morgenmad, et varmt frokostm�ltid, buffet til aftensmad og diverse mellemm�ltider i l�bet af dagen. Fri frugt, kaffe og te. Desuden er lokaleleje er inkluderet i prisen.</p>
        </td>
    </tr>
</table>

<p>Du er meget velkommen til at <a href="kontakt.php">ringe til os</a>, hvis du har foresp�rgsler p� skr�ddersyede arrangementer.</p>
');

$tpl->display('main-tpl.php');
?>

<?php
require_once 'include_kursuscenter.php';

$title = 'Kursuscenteret p� Vejle Idr�tsh�jskole - Faciliteter';
$meta['description'] = 'Faciliteterne p� Vejle Idr�tsh�jskoles kursuscenter.';
$meta['keywords'] = 'kursuscenter, jyske idr�tsskole, Vejle, faciliteter';

$tpl = new VIH_Frontend_Kursuscenter();
$tpl->set('title', $title);
$tpl->set('meta', $meta);

$tpl->set('content_main', '
<h1>Faciliteter</h1>

<div class="facilitet">
    <img src="images/globen1.jpg" width="200" height="135" />
    <h3>Globen - en verden af muligheder</h3>
    <p>Kursuscenteret r�der ogs� over en helt unik kongres- og foredragssal - Globen. I sig selv er Globen en arkitektonisk oplevelse. Salen har form som en kugle, og trods st�rrelsen er rumfornemmelsen intim - b�de til foredrag, f�llessang og koncerter med sm� ensembler.</p>
    <p>Der er plads til 157 mennesker i Globen, der med sin unikke form giver et �stetisk l�ft til et hvert arrangement. Globen er udstyret med moderne av-udstyr, bl.a. storsk�rm og tr�dl�se mikrofoner.</p>
</div>

<div class="facilitet">
    <h3>Auditorier og grupperum</h3>
    <img src="images/modelokale.jpg" width="200" height="135" alt="" />
    <ul>
        <li>To auditorier med plads til hhv. 50, og 20 personer</li>
        <li>Tre grupperum til ti personer</li>
        <li>En hyggelig opholdssstue med fjernsyn</li>
        <li>To idr�tshaller</li>
        <li>Natur- og kunstgr�sbaner</li>
    </ul>

    <p>Alle lokaler har dagslys og er lydt�tte. Desuden er de udstyret med moderne av-udstyr og adgang til Internet, som sikrer en effektiv og kraftfuld pr�sentation.</p></td>

</div>

<div class="facilitet">
    <img src="images/spisesal.jpg" width="200" height="159" alt="" />
    <h3>Spisesal</h3>
    <p>P� kursuscenteret spiser man sundt og varieret. Maden laver vi selv - helt fra bunden med friske r�varer og hjemmebag som basiselementer. Til frokost anrettes en stor buffet med lune retter, p�l�g og salatbar.</p>

</div>

<div class="facilitet">
    <img src="images/enkeltvaerelse.jpg" width="200" height="159"  />
    <h3>V�relser</h3>

    <p>Kursuscentret har 39 enkeltv�relser. Det giver en sengekapacitet p� 39 g�ster, men i perioden uden efterskole- og h�jskoleelever (juni-august) kan kapaciteten �ges til 207 personer.</p>

    <p>To enkeltv�relser deler �t bad og toilet.</p>
    <p>Alle v�relser er udstyret med tv.</p>

</div>

<div class="facilitet">
    <h3>�vrige faciliteter</h3>

    <p>Alle mulighederne er �bne, og alle faciliteter st�r til r�dighed. Man kan frit benytte h�jskolens inden- og udend�rs idr�tsfaciliteter i det omfang, de er ledige, blandt andet det opvarmede, udend�rs sv�mmebassin og saunaerne. </p>
    <p>I n�rheden af kursuscenteret er der ogs� mulighed for at spille golf og tennis eller tage en tur p� Vejle Fjord i kano eller kajak. Eller man kan bruge naturen lige uden for d�ren - og tage en vandre-, l�be- eller mountainbiketur i det kuperede terr�n. </p>

    <p><a href="http://www.vih.dk/faciliteter/">Se h�jskolens faciliteter</a></p>

</div>
');

$tpl->display('main-tpl.php');
?>
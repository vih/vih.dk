<?php
require_once 'include_kursuscenter.php';

$title = 'Kursuscenteret på Vejle Idrætshøjskole - Faciliteter';
$meta['description'] = 'Faciliteterne på Vejle Idrætshøjskoles kursuscenter.';
$meta['keywords'] = 'kursuscenter, jyske idrætsskole, Vejle, faciliteter';

$tpl = new VIH_Frontend_Kursuscenter();
$tpl->set('title', $title);
$tpl->set('meta', $meta);

$tpl->set('content_main', '
<h1>Faciliteter</h1>

<div class="facilitet">
    <img src="images/globen1.jpg" width="200" height="135" />
    <h3>Globen - en verden af muligheder</h3>
    <p>Kursuscenteret råder også over en helt unik kongres- og foredragssal - Globen. I sig selv er Globen en arkitektonisk oplevelse. Salen har form som en kugle, og trods størrelsen er rumfornemmelsen intim - både til foredrag, fællessang og koncerter med små ensembler.</p>
    <p>Der er plads til 157 mennesker i Globen, der med sin unikke form giver et æstetisk løft til et hvert arrangement. Globen er udstyret med moderne av-udstyr, bl.a. storskærm og trådløse mikrofoner.</p>
</div>

<div class="facilitet">
    <h3>Auditorier og grupperum</h3>
    <img src="images/modelokale.jpg" width="200" height="135" alt="" />
    <ul>
        <li>To auditorier med plads til hhv. 50, og 20 personer</li>
        <li>Tre grupperum til ti personer</li>
        <li>En hyggelig opholdssstue med fjernsyn</li>
        <li>To idrætshaller</li>
        <li>Natur- og kunstgræsbaner</li>
    </ul>

    <p>Alle lokaler har dagslys og er lydtætte. Desuden er de udstyret med moderne av-udstyr og adgang til Internet, som sikrer en effektiv og kraftfuld præsentation.</p></td>

</div>

<div class="facilitet">
    <img src="images/spisesal.jpg" width="200" height="159" alt="" />
    <h3>Spisesal</h3>
    <p>På kursuscenteret spiser man sundt og varieret. Maden laver vi selv - helt fra bunden med friske råvarer og hjemmebag som basiselementer. Til frokost anrettes en stor buffet med lune retter, pålæg og salatbar.</p>

</div>

<div class="facilitet">
    <img src="images/enkeltvaerelse.jpg" width="200" height="159"  />
    <h3>Værelser</h3>

    <p>Kursuscentret har 39 enkeltværelser. Det giver en sengekapacitet på 39 gæster, men i perioden uden efterskole- og højskoleelever (juni-august) kan kapaciteten øges til 207 personer.</p>

    <p>To enkeltværelser deler ét bad og toilet.</p>
    <p>Alle værelser er udstyret med tv.</p>

</div>

<div class="facilitet">
    <h3>Øvrige faciliteter</h3>

    <p>Alle mulighederne er åbne, og alle faciliteter står til rådighed. Man kan frit benytte højskolens inden- og udendørs idrætsfaciliteter i det omfang, de er ledige, blandt andet det opvarmede, udendørs svømmebassin og saunaerne. </p>
    <p>I nærheden af kursuscenteret er der også mulighed for at spille golf og tennis eller tage en tur på Vejle Fjord i kano eller kajak. Eller man kan bruge naturen lige uden for døren - og tage en vandre-, løbe- eller mountainbiketur i det kuperede terræn. </p>

    <p><a href="http://www.vih.dk/faciliteter/">Se højskolens faciliteter</a></p>

</div>
');

$tpl->display('main-tpl.php');
?>
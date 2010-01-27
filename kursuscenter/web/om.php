<?php
require 'include_kursuscenter.php';

$title = 'Kursuscenteret på Vejle Idrætshøjskole - Om kursuscenteret';
$meta['description'] = 'Et kursuscenter der er andet end auditorium og grupperum, men det er der også. Konferencer lever ikke af ord alene. Foredragssal til 157 personer med AV-muligheder.';
$meta['keywords'] = 'kursuscenter, jyske idrætsskole, Vejle';

$tpl = new VIH_Frontend_Kursuscenter();
$tpl->set('title', $title);
$tpl->set('meta', $meta);

$tpl->set('content_main', '

<img src="images/hall.jpg" alt="" />

<h1>Om kursuscenteret</h1>
<p>Kursuscenteret ligger i forbindelse med Vejle Idrætshøjskole i et af landets smukkeste naturområder.</p>
<p>Med idrætshøjskolens pulserende liv som kulisse er kursuscenteret et aktivt alternativ til mere gængse kursuscentre.</p>
<p>På kursuscentret er der ro til at arbejde i et spændende og afslappet miljø med alle moderne kursusfaciliteter, og samtidig har centeret helt enestående faciliteter til et hav af forskellige aktiviteter i fritiden</p>
<p>En perfekt og inspirerende ramme om såvel idrætslige som ikke-idrætslige kurser. Man kan som kursist vælge at nyde sine få fritimer i fred og ro, gå en tur i den storslåede natur lige uden for døren eller tage del i det pulserende liv omkring centret og idrætshøjskolen - enten som tilskuer eller som deltager.</p>
<p>Centret er skabt af Vejle Idrætshøjskole og Danmarks Idræts-Forbund og er samtidig Team Danmarks træningscenter for fodbold.</p>
');

$tpl->display('main-tpl.php');
?>
<?php
require 'include_kursuscenter.php';

$title = 'Kursuscenteret p� Vejle Idr�tsh�jskole - Om kursuscenteret';
$meta['description'] = 'Et kursuscenter der er andet end auditorium og grupperum, men det er der ogs�. Konferencer lever ikke af ord alene. Foredragssal til 157 personer med AV-muligheder.';
$meta['keywords'] = 'kursuscenter, jyske idr�tsskole, Vejle';

$tpl = new VIH_Frontend_Kursuscenter();
$tpl->set('title', $title);
$tpl->set('meta', $meta);

$tpl->set('content_main', '

<img src="images/hall.jpg" alt="" />

<h1>Om kursuscenteret</h1>
<p>Kursuscenteret ligger i forbindelse med Vejle Idr�tsh�jskole i et af landets smukkeste naturomr�der.</p>
<p>Med idr�tsh�jskolens pulserende liv som kulisse er kursuscenteret et aktivt alternativ til mere g�ngse kursuscentre.</p>
<p>P� kursuscentret er der ro til at arbejde i et sp�ndende og afslappet milj� med alle moderne kursusfaciliteter, og samtidig har centeret helt enest�ende faciliteter til et hav af forskellige aktiviteter i fritiden</p>
<p>En perfekt og inspirerende ramme om s�vel idr�tslige som ikke-idr�tslige kurser. Man kan som kursist v�lge at nyde sine f� fritimer i fred og ro, g� en tur i den storsl�ede natur lige uden for d�ren eller tage del i det pulserende liv omkring centret og idr�tsh�jskolen - enten som tilskuer eller som deltager.</p>
<p>Centret er skabt af Vejle Idr�tsh�jskole og Danmarks Idr�ts-Forbund og er samtidig Team Danmarks tr�ningscenter for fodbold.</p>
');

$tpl->display('main-tpl.php');
?>
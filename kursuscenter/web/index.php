<?php
require 'include_kursuscenter.php';

$title = 'Vejle Idr�tsh�jskoles kursuscenter - mere end et kursuscenter';
$meta = array(
    'keywords' => 'kursuscenter, kursus, kurser, jyske idr�tsskole, konferencenter',
    'description' => 'Et moderne kursuscenter p� Vejle Idr�tsh�jskole. Et kursuscenter med gode konference- og idr�tsfaciliteter.'
);

$tpl = new VIH_Frontend_Kursuscenter();
$tpl->set('title', $title);
$tpl->set('meta', $meta);

$tpl->set('content_main', '
    <img src="images/globenkursuscenter.jpg" alt="Billede af Vejle Idr�tsh�jskole kursuscenter" />

    <h1>Kursuscenter med ekstra overskud...</h1>

    <p>Vejle Idr�tsh�jskoles kursuscenter er klar til at danne rammerne om dit kursus. S�vel virksomheder, organisationer og foreninger er velkomne.</p>
    <p>Du kan diskutere i sm� grupperum, h�re efter i store auditorier eller udfolde dig fysisk p� vores kunstgr�sbane, i idr�tshallerne, styrketr�ningslokalet, den udend�rs swimmingpool eller p� vores beach volley baner.</p>
');

$tpl->display('main-tpl.php');
?>
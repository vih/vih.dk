<?php
require 'include_kursuscenter.php';

$title = 'Vejle Idrætshøjskoles kursuscenter - mere end et kursuscenter';
$meta = array(
    'keywords' => 'kursuscenter, kursus, kurser, jyske idrætsskole, konferencenter',
    'description' => 'Et moderne kursuscenter på Vejle Idrætshøjskole. Et kursuscenter med gode konference- og idrætsfaciliteter.'
);

$tpl = new VIH_Frontend_Kursuscenter();
$tpl->set('title', $title);
$tpl->set('meta', $meta);

$tpl->set('content_main', '
    <img src="images/globenkursuscenter.jpg" alt="Billede af Vejle Idrætshøjskole kursuscenter" />

    <h1>Kursuscenter med ekstra overskud...</h1>

    <p>Vejle Idrætshøjskoles kursuscenter er klar til at danne rammerne om dit kursus. Såvel virksomheder, organisationer og foreninger er velkomne.</p>
    <p>Du kan diskutere i små grupperum, høre efter i store auditorier eller udfolde dig fysisk på vores kunstgræsbane, i idrætshallerne, styrketræningslokalet, den udendørs swimmingpool eller på vores beach volley baner.</p>
');

$tpl->display('main-tpl.php');
?>
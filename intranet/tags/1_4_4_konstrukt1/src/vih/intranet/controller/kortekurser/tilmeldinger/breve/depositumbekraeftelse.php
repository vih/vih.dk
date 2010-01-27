<?php

// oplysningert til inds�ttelse i teksten

$navn = $tilmelding->get('navn');
$ordrenummer = $tilmelding->get("id");
$kursus = $tilmelding->kursus->get("kursusnavn");
$afsendernavn = "";
$tilmelding->loadBetaling();
$betalt = intval($tilmelding->get('betalt'));
$skyldig = intval($tilmelding->get('skyldig'));
$forfaldsdato = $tilmelding->get('dato_forfalden_dk');
$forsikring = "";
if ($tilmelding->get('afbestillingsforsikring') == 'Ja') {
    $forsikring = " afbestillingsforsikring og";
}
$onlinebetaling = 'eller online p� adressen ' . KORTEKURSER_LOGIN_URI . $tilmelding->get('code');

$deltagere = count($tilmelding->getDeltagere());
if ($deltagere == 1) {
    $stedord = 'din tilmelding';
}
else {
    $stedord = 'din tilmelding for ' . $deltagere . ' deltagere';
}

$brev_tekst = <<<EODTEKST
K�re $navn

Hermed bekr�fter vi, at vi har modtaget din betaling p� $betalt kroner. Den d�kker$forsikring depositum for kurset $kursus.

Dit ordrenummer er: $ordrenummer

Derved tr�der $stedord i kraft. Husk at betale det resterende bel�b $skyldig kroner senest $forfaldsdato.

Pengene bedes overf�rt til vores konto i Jyske Bank: 7244-1469664 $onlinebetaling.

Med venlig hilsen

$afsendernavn
Vejle Idr�tsh�jskole
Telefon: 75820811
EODTEKST;

?>
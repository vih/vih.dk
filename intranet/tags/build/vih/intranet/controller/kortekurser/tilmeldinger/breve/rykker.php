<?php
// oplysningert til inds�ttelse i teksten

$navn = $tilmelding->get('navn');
$ordrenummer = $tilmelding->get("id");
$kursus = $tilmelding->kursus->get("kursusnavn");
$tilmelding->loadBetaling();
$pris = intval($tilmelding->get('pris'));
$skyldig =  intval($tilmelding->get('skyldig'));
$afsendernavn = "";
$onlinebetaling = 'eller online p� adressen '.KORTEKURSER_LOGIN_URI.$tilmelding->get('code');

$brev_tekst = <<<EODTEKST
K�re $navn

Ved gennemgang af vort bogholderi har vi konstateret, at du endnu mangler at indbetale $skyldig kroner for $kursus.

Dit ordrenummer er: $ordrenummer

Pengene bedes overf�rt til vores konto i Jyske Bank: 7244-1469664 $onlinebetaling.

S�fremt bel�bet er betalt, m� du meget gerne ringe til os og oplyse, hvilken dato pengene er blevet indbetalt.

Hvis vi ikke h�rer fra dig, g�r vi ud fra at du ikke �nsker at opretholde din tilmelding.

Med venlig hilsen

$afsendernavn
Vejle Idr�tsh�jskole
Telefon: 75820811

EODTEKST;

?>
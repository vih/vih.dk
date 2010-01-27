<?php


// oplysningert til inds�ttelse i teksten

$navn = $tilmelding->get('navn');
$ordrenummer = $tilmelding->get("id");
$tilmelding->loadBetaling();
$kursus = $tilmelding->kursus->get("kursusnavn");
$skyldig = intval($tilmelding->get("skyldig_depositum"));
$afsendernavn = "";
$onlinebetaling = 'eller online p� adressen '.  KORTEKURSER_LOGIN_URI .$tilmelding->get('code');
$forsikring = '';
if ($tilmelding->get('afbestillingsforsikring') == 'Ja') {
    $forsikring = " afbestillingsforsikring og";
}


$brev_tekst = <<<EODTEKST
K�re $navn

Ved gennemgang af vort bogholderi har vi konstateret, at du endnu mangler at indbetale dit depositum for $kursus.

Du skal indbetale $skyldig kroner, som d�kker$forsikring depositum, s� hurtigt som muligt.

Dit ordrenummer er: $ordrenummer

Pengene bedes overf�rt til vores konto i Jyske Bank: 7244-1469664 $onlinebetaling.

S�fremt bel�bet er betalt, m� du meget gerne ringe til os og oplyse, hvilken dato pengene er blevet indbetalt.

Hvis vi ikke h�rer fra dig, g�r vi ud fra at du ikke �nsker at opretholde din tilmelding. Tilmeldingen annulleres i l�bet af en uge.

Med venlig hilsen

$afsendernavn
Vejle Idr�tsh�jskole
Telefon: 75820811

EODTEKST;

?>
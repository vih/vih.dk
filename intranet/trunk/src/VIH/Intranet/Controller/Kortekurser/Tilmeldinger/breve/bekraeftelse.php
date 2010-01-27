<?php 

// oplysningert til inds�ttelse i teksten


$navn = $tilmelding->get('navn');
$ordrenummer = $tilmelding->get("id");
$kursus = $tilmelding->kursus->get("kursusnavn");
$afsendernavn = "";
$tilmelding->loadBetaling();
$deltagere = count($tilmelding->getDeltagere());
if ($deltagere == 1) {
	$stedord = 'du';
}
else {
$stedord = '' . $deltagere . ' deltagere ';
}
$betalt = intval($tilmelding->get('betalt'));
$forsikring = '';
if ($tilmelding->get('afbestillingsforsikring') == 'Ja') {
	$forsikring = ' afbestillingsforsikring og ';
}


$brev_tekst = <<<EODTEKST
K�re $navn

Tak for tilmeldingen til $kursus. Vi har noteret, at der er indbetalt $betalt kroner, som d�kker$forsikring kursusprisen.

Dit tilmeldingsnummer er: $ordrenummer

Vi kan bekr�fte, at $stedord er optaget p� kurset.

Vi sender programmet ud cirka to uger f�r kurset starter.

P� gensyn i Vejle.

Med venlig hilsen


$afsendernavn
Vejle Idr�tsh�jskole
Telefon: 75820811
EODTEKST;

?>
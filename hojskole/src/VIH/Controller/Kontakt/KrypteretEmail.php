<?php
/*
require('../include_vih.php');

$title = 'Krypteret e-mail og digital signatur';
$meta['description'] = 'Her kan du læse mere om, hvordan du kan sende en krypteret e-mail til Vejle Idrætshøjskole';
$meta['keywords'] = 'krypteret e-mail, digital signatur';

$main = new VIH_Frontend_Hojskole();
$main->set('title', $title);
$main->set('meta', $meta);
$main->set('body_class', 'sidebar');

$main->set('content_main', '
<h1>Sikker e-mail til Vejle Idrætshøjskole</h1>
<p><strong>Hvis du har en digital signatur fra TDC, kan du sende sikker e-mail til Vejle Idrætshøjskole. Hvis du ikke har en digital signatur, kan du bestille en, men så går der lige et par dage, inden du får din pinkode til signaturen - se mere på <a href="http://www.digitalsignatur.dk/">www.digitalsignatur.dk</a>.</strong></p>
<ul>
    <li><a href="#certifikater">Download højskolens certifikater</a></li>
    <li><a href="#vejledning">Vejledning til hvordan du installerer certifikaterne hos dig selv</a></li>
    <li><a href="#links">Hvor bestiller du digital signatur</a></li>
</ul>

<h3>Hvad er digital signatur?</h3>
<p>Digital signatur er en teknisk måde at sikre sin e-mail på. Signaturen giver sikkerhed for, at meddelelsen kommer fra den anførte afsender, og at den ikke er blevet ændret undervejs.</p>
<p>Derudover kan man vælge at kryptere e-mailen, så ingen uvedkommende kan læse den. Dette kræver dog, at man har modtagerens digitale signatur.</p>
<p>En digital signatur er lige så juridisk bindende som en almindelig underskrift.</p>
<p>Når man sender en e-mail som er krypteret og signeret kaldes det sikker e-mail.</p>

<h3>Sikker e-mail til højskolen</h3>
<p>Vi er i øjeblikket ved at implementere medarbejdersignaturer, så du kan sende krypterede e-mails til højskolen. For at kunne sende krypterede e-mails til højskolen, skal du have højskolens certifikat. De fleste nyere postprogrammer understøtter digital signatur. Nogle programmer installerer automatisk certifikaterne, mens du i andre programmer måske skal bruge et særligt certifikat.</p>
<p> Allerede nu kan du sende krypterede e-mails til følgende adresser - og du finder de tilhørende certifikater ved siden af adressen:</p>

<table summary="Certifikater til sikker e-mail" id="certifikater">
<caption>Certifikater til sikker e-mail</caption>
<tr>
    <th>E-mail</th>
    <th>Certifikat</th>
</tr>
<tr>
    <td>Kontoret (Gunhild Mortensen)</td>
    <td>' . email('kontor@vih.dk') . '</td>
    <td>
        <ul>
            <li><a href="certifikater/vcf.php?f=Kontor">Certifikat til Microsoft</a></li>
            <li><a href="certifikater/cer.php?f=Kontor">Certifikat til Mozilla</a></li>
        </td>
</tr>
<tr>
    <td>Torkil Christensen (kursuschef)</td>
    <td>'. email('torkil@vih.dk') . '</td>
    <td>
        <ul>
            <li><a href="certifikater/vcf.php?f=Torkil">Certifikat til Microsoft</a></li>
            <li><a href="certifikater/cer.php?f=Torkil">Certifikat til Mozilla</a></li>
        </td>
</tr>

<tr>
    <td>Lars Olesen (webmaster)</td>
    <td>' . email('lars@vih.dk') . '</td>
    <td>
        <ul>
            <li><a href="certifikater/vcf.php?f=Lars">Certifikat til Microsoft</a></li>
            <li><a href="certifikater/cer.php?f=Lars">Certifikat til Mozilla</a></li>
        </td>
</tr>
</table>

<p>I nogle e-mailprogrammer og i nogle større virksomheder er det ikke nødvendigt at hente vores certifikat, men ellers kan du se vejledninger til, hvordan du installerer vores certifikat nedenunder.</p>
<p>Vi opfordrer alle kunder og samarbejdspartnere til at sende fortrolig post digitalt til højskolen via sikker e-mail.</p>

<h3 id="vejledning">Vejledning til installation af certifikat</h3>

<p>Hvis du vil sende krypteret email til en person, skal du have modtagerens digitale id (dvs. digitale signatur og offentlige nøgle), og dette id skal være knyttet til modtagerens navn i adressekartoteket.</p>

<h4>Microsoft Outlook (Express)</h4>

<p>I Outlook (Express) føjes digitale id\'er automatisk til adressekartoteket, når du modtager en email, der er signeret digitalt. Hvis du har deaktiveret denne indstilling, skal du tilføje en persons digitale id manuelt.</p>

<ol>
<li>Åbn meddelelsen med den digitale signatur.</li>
<li>Klik på <strong>Filer &rarr; Egenskaber</strong>.</li>
<li>Klik på fanen <strong>Sikkerhed</strong>, og klik derefter på <strong>Vis certifikater</strong>. Klik på <strong>Føj til adressekartotek</strong> for at knytte det digitale id til afsenderen eller oprette afsenderen i adressebogen sammen med digital id. Når en kontaktperson har et digitalt id, føjes et rødt bånd til personens kort i adressekartoteket.</li>
</ol>

<p>Sådan føjes et digitalt id til adressekartoteket fra en fil.</p>

<ol>
<li>Opret en ny adresse til kontaktpersonen i adressekartoteket, eller dobbeltklik på en eksisterende adresse på adressekartotekslisten.</li>
<li>Klik på <strong>Importer</strong> under fanen <strong>Digitale id\'er</strong>.</li>
<li>Søg efter filen med det digitale id, og klik derefter på <strong>Åbn</strong>.</li>
</ol>

<p><em>Bemærk!</em>: Hvis du vil have, at en kontaktpersons digitale id automatisk skal tilføjes i adressekartoteket, skal du klikke på <strong>Funktioner &rarr; Indstillinger</strong>. Klik derefter på <strong>Avanceret</strong> under fanen <strong>Sikkerhed</strong>, og marker afkrydsningsfeltet <strong>Tilføj afsenders certifikater til mit adressekartotek</strong>.</p>

<h5>Kryptering af emails</h5>
<p>For at kryptere en email, skal du oprette en ny meddelelse til f.eks. '.email('lars@vih.dk').' og vælge kryptering på en af følgende måder:</p>

<ol>
<li>Vælg <strong>Funktioner &rarr; Krypter</strong></li>
<li>Klik på <strong>Krypter</strong> ikonet på værktøjslinien</li>
</ol>
<p>Når krypteringen er slået til vises der en lille hængelås i højre side af meddelelsesvinduet og du kan nu vedhæfte indberetningsfilen og sende meddelelsen afsted.</p>


<h4>Mozilla / Netscape Messenger</h4>
<p>Ved modtagelse af en signeret email fra f.eks. ' . email('lars@vih.dk') . ' i Netscape Messenger eller Mozilla, tilføjer programmet automatisk den offentlige nøgle til listen over certifikater.</p>
<p>Afsendelse af krypteret email foregår så ved at oprette en ny email til ' . email('lars@vih.dk') . ' og vælge <strong>Options &rarr; Security</strong>.</p>

<p>Her kan du vælge at kryptere emailen ved at krydse feltet <strong>Encrypt this message</strong>.</p>
<p>Hvis feltet ikke vises, kan det være fordi du ikke har skrevet email adressen rigtigt og programmet vil så skrive at der ikke findes et certifikat til den angivne modtager adresse.</p>

<p>Når du har sendt beskeden, vil du i <strong>Sent</strong> folderen kunne se at meddelelsen er krypteret hvis der vises et ikon med teksten <strong>Encrypted</strong> i højre side mailvinduet.</p>


    <ul>
        <li><a href="http://www.digitalsignatur.dk/">Læs mere om de nye offentlige digitale signaturer</a></li>
        <li><a href="https://bestilling.certifikat.tdc.dk/pocesapply/jsp/index.jsp?">Bestil en digital signatur fra TDC</a></li>
    </ul>

');

$main->set('content_sub', '');


*/
?>
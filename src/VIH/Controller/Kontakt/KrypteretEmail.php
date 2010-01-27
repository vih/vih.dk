<?php
/*
require('../include_vih.php');

$title = 'Krypteret e-mail og digital signatur';
$meta['description'] = 'Her kan du l�se mere om, hvordan du kan sende en krypteret e-mail til Vejle Idr�tsh�jskole';
$meta['keywords'] = 'krypteret e-mail, digital signatur';

$main = new VIH_Frontend_Hojskole();
$main->set('title', $title);
$main->set('meta', $meta);
$main->set('body_class', 'sidebar');

$main->set('content_main', '
<h1>Sikker e-mail til Vejle Idr�tsh�jskole</h1>
<p><strong>Hvis du har en digital signatur fra TDC, kan du sende sikker e-mail til Vejle Idr�tsh�jskole. Hvis du ikke har en digital signatur, kan du bestille en, men s� g�r der lige et par dage, inden du f�r din pinkode til signaturen - se mere p� <a href="http://www.digitalsignatur.dk/">www.digitalsignatur.dk</a>.</strong></p>
<ul>
    <li><a href="#certifikater">Download h�jskolens certifikater</a></li>
    <li><a href="#vejledning">Vejledning til hvordan du installerer certifikaterne hos dig selv</a></li>
    <li><a href="#links">Hvor bestiller du digital signatur</a></li>
</ul>

<h3>Hvad er digital signatur?</h3>
<p>Digital signatur er en teknisk m�de at sikre sin e-mail p�. Signaturen giver sikkerhed for, at meddelelsen kommer fra den anf�rte afsender, og at den ikke er blevet �ndret undervejs.</p>
<p>Derudover kan man v�lge at kryptere e-mailen, s� ingen uvedkommende kan l�se den. Dette kr�ver dog, at man har modtagerens digitale signatur.</p>
<p>En digital signatur er lige s� juridisk bindende som en almindelig underskrift.</p>
<p>N�r man sender en e-mail som er krypteret og signeret kaldes det sikker e-mail.</p>

<h3>Sikker e-mail til h�jskolen</h3>
<p>Vi er i �jeblikket ved at implementere medarbejdersignaturer, s� du kan sende krypterede e-mails til h�jskolen. For at kunne sende krypterede e-mails til h�jskolen, skal du have h�jskolens certifikat. De fleste nyere postprogrammer underst�tter digital signatur. Nogle programmer installerer automatisk certifikaterne, mens du i andre programmer m�ske skal bruge et s�rligt certifikat.</p>
<p> Allerede nu kan du sende krypterede e-mails til f�lgende adresser - og du finder de tilh�rende certifikater ved siden af adressen:</p>

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

<p>I nogle e-mailprogrammer og i nogle st�rre virksomheder er det ikke n�dvendigt at hente vores certifikat, men ellers kan du se vejledninger til, hvordan du installerer vores certifikat nedenunder.</p>
<p>Vi opfordrer alle kunder og samarbejdspartnere til at sende fortrolig post digitalt til h�jskolen via sikker e-mail.</p>

<h3 id="vejledning">Vejledning til installation af certifikat</h3>

<p>Hvis du vil sende krypteret email til en person, skal du have modtagerens digitale id (dvs. digitale signatur og offentlige n�gle), og dette id skal v�re knyttet til modtagerens navn i adressekartoteket.</p>

<h4>Microsoft Outlook (Express)</h4>

<p>I Outlook (Express) f�jes digitale id\'er automatisk til adressekartoteket, n�r du modtager en email, der er signeret digitalt. Hvis du har deaktiveret denne indstilling, skal du tilf�je en persons digitale id manuelt.</p>

<ol>
<li>�bn meddelelsen med den digitale signatur.</li>
<li>Klik p� <strong>Filer &rarr; Egenskaber</strong>.</li>
<li>Klik p� fanen <strong>Sikkerhed</strong>, og klik derefter p� <strong>Vis certifikater</strong>. Klik p� <strong>F�j til adressekartotek</strong> for at knytte det digitale id til afsenderen eller oprette afsenderen i adressebogen sammen med digital id. N�r en kontaktperson har et digitalt id, f�jes et r�dt b�nd til personens kort i adressekartoteket.</li>
</ol>

<p>S�dan f�jes et digitalt id til adressekartoteket fra en fil.</p>

<ol>
<li>Opret en ny adresse til kontaktpersonen i adressekartoteket, eller dobbeltklik p� en eksisterende adresse p� adressekartotekslisten.</li>
<li>Klik p� <strong>Importer</strong> under fanen <strong>Digitale id\'er</strong>.</li>
<li>S�g efter filen med det digitale id, og klik derefter p� <strong>�bn</strong>.</li>
</ol>

<p><em>Bem�rk!</em>: Hvis du vil have, at en kontaktpersons digitale id automatisk skal tilf�jes i adressekartoteket, skal du klikke p� <strong>Funktioner &rarr; Indstillinger</strong>. Klik derefter p� <strong>Avanceret</strong> under fanen <strong>Sikkerhed</strong>, og marker afkrydsningsfeltet <strong>Tilf�j afsenders certifikater til mit adressekartotek</strong>.</p>

<h5>Kryptering af emails</h5>
<p>For at kryptere en email, skal du oprette en ny meddelelse til f.eks. '.email('lars@vih.dk').' og v�lge kryptering p� en af f�lgende m�der:</p>

<ol>
<li>V�lg <strong>Funktioner &rarr; Krypter</strong></li>
<li>Klik p� <strong>Krypter</strong> ikonet p� v�rkt�jslinien</li>
</ol>
<p>N�r krypteringen er sl�et til vises der en lille h�ngel�s i h�jre side af meddelelsesvinduet og du kan nu vedh�fte indberetningsfilen og sende meddelelsen afsted.</p>


<h4>Mozilla / Netscape Messenger</h4>
<p>Ved modtagelse af en signeret email fra f.eks. ' . email('lars@vih.dk') . ' i Netscape Messenger eller Mozilla, tilf�jer programmet automatisk den offentlige n�gle til listen over certifikater.</p>
<p>Afsendelse af krypteret email foreg�r s� ved at oprette en ny email til ' . email('lars@vih.dk') . ' og v�lge <strong>Options &rarr; Security</strong>.</p>

<p>Her kan du v�lge at kryptere emailen ved at krydse feltet <strong>Encrypt this message</strong>.</p>
<p>Hvis feltet ikke vises, kan det v�re fordi du ikke har skrevet email adressen rigtigt og programmet vil s� skrive at der ikke findes et certifikat til den angivne modtager adresse.</p>

<p>N�r du har sendt beskeden, vil du i <strong>Sent</strong> folderen kunne se at meddelelsen er krypteret hvis der vises et ikon med teksten <strong>Encrypted</strong> i h�jre side mailvinduet.</p>


    <ul>
        <li><a href="http://www.digitalsignatur.dk/">L�s mere om de nye offentlige digitale signaturer</a></li>
        <li><a href="https://bestilling.certifikat.tdc.dk/pocesapply/jsp/index.jsp?">Bestil en digital signatur fra TDC</a></li>
    </ul>

');

$main->set('content_sub', '');


*/
?>
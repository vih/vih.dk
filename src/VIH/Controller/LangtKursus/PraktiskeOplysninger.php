<?php
class VIH_Controller_LangtKursus_PraktiskeOplysninger extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'Praktiske oplysninger om lange kurser';
        $meta['description'] = 'Praktiske oplysninger vedr. lange kurser p� Vejle Idr�tsh�jskole. Bl.a. hvilken alder du skal have for at starte.';
        $meta['keywords'] = 'praktiske, oplysninger, indkvartering, indmeldelse, indmelding, v�relser, indkvartering, frihed, fri, hvor gammel, alder, kostpolitik, optagelse, opskrivning';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        return '
        <h1>Praktiske oplysninger</h1>
        <h3>Bestil materiale</h3>
        <p>Du kan bestille vores brochurer p� vores <a href="'.url('/bestilling').'">onlinebestillingsformular</a>.</p>
        <h2>Indmelding</h2>
        <p>Du skal v�re 17�; �r, n�r du indmelder dig p� Vejle Idr�tsh�jskole. Du er indmeldt, n�r du har sendt ans�gningskort samt tilmeldingsgebyr til os. Du f�r skriftlig besked, n�r du er optaget.</p>
        <p>Hvis du vil tilmelde dig et af de lange kurser p� Vejle Idr�tsh�jskole, kan du <a href="'.url('/langekurser').'">finde det kursus</a>, du gerne vil tilmeldes og derfra bruge vores onlinetilmeldingsformular.</p>
        <h2>Skrevet op</h2>
        <p>Du kan ogs� blive skrevet op, hvis du gerne vil reservere en plads.</p>
        <h2>Indkvartering</h2>
        <p>Du kommer til at bo p� dobbeltv�relse. I fordelingen af v�relser tages der hensyn til, om du er ryger eller ikke-ryger. </p>
        <h2>Frihed</h2>
        <p>Du har fri i weekenderne, medmindre skolen har et planlagt arrangement. Du er selvf�lgelig altid meget velkommen til at blive p� skolen i weekenden og deltage i de aktiviteter, som I aftaler og planl�gger indbyrdes. Du kan ikke f� ferie i skoleforl�bet, men du kan s�ge om begrundet frihed.</p>
        <h2>Alkoholpolitik</h2>
        <p>�l og vin nyder vi i weekenden, men vi accepterer ikke misbrug. Du bliver informeret om alkoholpolitikken ved ankomsten. Du er i �vrigt velkommen til at ringe og sp�rge. </p>
        <h2>Den gode mad</h2>
        <p>Der klages ikke over maden. Vejle Idr�tsh�jskole er anerkendt af Team Danmarks di�tister for at servere en sund kost. B�de frokost og aften er der en varieret salatbar. K�kkenet laver ogs� vegetarretter.</p>
        ';
    }
}
?>
<?php
class VIH_Controller_LangtKursus_PraktiskeOplysninger extends k_Controller
{
    function GET()
    {
        $title = 'Praktiske oplysninger om lange kurser';
        $meta['description'] = 'Praktiske oplysninger vedr. lange kurser på Vejle Idrætshøjskole. Bl.a. hvilken alder du skal have for at starte.';
        $meta['keywords'] = 'praktiske, oplysninger, indkvartering, indmeldelse, indmelding, værelser, indkvartering, frihed, fri, hvor gammel, alder, kostpolitik, optagelse, opskrivning';

        $this->document->title = $title;
        $this->document->meta = $meta;

        return '
        <h1>Praktiske oplysninger</h1>
        <h3>Bestil materiale</h3>
        <p>Du kan bestille vores brochurer på vores <a href="'.url('/bestilling').'">onlinebestillingsformular</a>.</p>
        <h2>Indmelding</h2>
        <p>Du skal være 17½; år, når du indmelder dig på Vejle Idrætshøjskole. Du er indmeldt, når du har sendt ansøgningskort samt tilmeldingsgebyr til os. Du får skriftlig besked, når du er optaget.</p>
        <p>Hvis du vil tilmelde dig et af de lange kurser på Vejle Idrætshøjskole, kan du <a href="'.url('/langekurser').'">finde det kursus</a>, du gerne vil tilmeldes og derfra bruge vores onlinetilmeldingsformular.</p>
        <h2>Skrevet op</h2>
        <p>Du kan også blive skrevet op, hvis du gerne vil reservere en plads.</p>
        <h2>Indkvartering</h2>
        <p>Du kommer til at bo på dobbeltværelse. I fordelingen af værelser tages der hensyn til, om du er ryger eller ikke-ryger. </p>
        <h2>Frihed</h2>
        <p>Du har fri i weekenderne, medmindre skolen har et planlagt arrangement. Du er selvfølgelig altid meget velkommen til at blive på skolen i weekenden og deltage i de aktiviteter, som I aftaler og planlægger indbyrdes. Du kan ikke få ferie i skoleforløbet, men du kan søge om begrundet frihed.</p>
        <h2>Alkoholpolitik</h2>
        <p>Øl og vin nyder vi i weekenden, men vi accepterer ikke misbrug. Du bliver informeret om alkoholpolitikken ved ankomsten. Du er i øvrigt velkommen til at ringe og spørge. </p>
        <h2>Den gode mad</h2>
        <p>Der klages ikke over maden. Vejle Idrætshøjskole er anerkendt af Team Danmarks diætister for at servere en sund kost. Både frokost og aften er der en varieret salatbar. Køkkenet laver også vegetarretter.</p>
        ';
    }
}
?>
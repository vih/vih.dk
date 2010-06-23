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
        $meta['description'] = 'Praktiske oplysninger vedr. lange kurser pï¿½ Vejle Idrï¿½tshï¿½jskole. Bl.a. hvilken alder du skal have for at starte.';
        $meta['keywords'] = 'praktiske, oplysninger, indkvartering, indmeldelse, indmelding, vï¿½relser, indkvartering, frihed, fri, hvor gammel, alder, kostpolitik, optagelse, opskrivning';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        return '
        <h1>Praktiske oplysninger</h1>
        <h3>Bestil materiale</h3>
        <p>Du kan bestille vores brochurer pï¿½ vores <a href="'.url('/bestilling').'">onlinebestillingsformular</a>.</p>
        <h2>Indmelding</h2>
        <p>Du skal vï¿½re 17ï¿½; ï¿½r, nï¿½r du indmelder dig pï¿½ Vejle Idrï¿½tshï¿½jskole. Du er indmeldt, nï¿½r du har sendt ansï¿½gningskort samt tilmeldingsgebyr til os. Du fï¿½r skriftlig besked, nï¿½r du er optaget.</p>
        <p>Hvis du vil tilmelde dig et af de lange kurser pï¿½ Vejle Idrï¿½tshï¿½jskole, kan du <a href="'.url('/langekurser').'">finde det kursus</a>, du gerne vil tilmeldes og derfra bruge vores onlinetilmeldingsformular.</p>
        <h2>Skrevet op</h2>
        <p>Du kan ogsï¿½ blive skrevet op, hvis du gerne vil reservere en plads.</p>
        <h2>Indkvartering</h2>
        <p>Du kommer til at bo pï¿½ dobbeltvï¿½relse. I fordelingen af vï¿½relser tages der hensyn til, om du er ryger eller ikke-ryger. </p>
        <h2>Frihed</h2>
        <p>Du har fri i weekenderne, medmindre skolen har et planlagt arrangement. Du er selvfï¿½lgelig altid meget velkommen til at blive pï¿½ skolen i weekenden og deltage i de aktiviteter, som I aftaler og planlï¿½gger indbyrdes. Du kan ikke fï¿½ ferie i skoleforlï¿½bet, men du kan sï¿½ge om begrundet frihed.</p>
        <h2>Alkoholpolitik</h2>
        <p>ï¿½l og vin nyder vi i weekenden, men vi accepterer ikke misbrug. Du bliver informeret om alkoholpolitikken ved ankomsten. Du er i ï¿½vrigt velkommen til at ringe og spï¿½rge. </p>
        <h2>Den gode mad</h2>
        <p>Der klages ikke over maden. Vejle Idrï¿½tshï¿½jskole er anerkendt af Team Danmarks diï¿½tister for at servere en sund kost. Bï¿½de frokost og aften er der en varieret salatbar. Kï¿½kkenet laver ogsï¿½ vegetarretter.</p>
        ';
    }
}
?>
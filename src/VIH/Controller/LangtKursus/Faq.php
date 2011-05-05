<?php
class VIH_Controller_LangtKursus_Faq extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'Spørgsmål og svar om de lange kurser';
        $meta['description'] = 'Ofte stillde spørgsmål, spørgsmål og svar, frequently asked questions, faq';
        $meta['keywords'] = 'spørgsmål, faq, oss, frequently asked questions, svar';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        return '
        <h1>Spørgsmål og svar</h1>
        <p>Her har vi forsøgt at samle svarene på nogle af de spørgsmål, vi ofte bliver stillet.</p>
        <h3>1. Hvad koster et ophold?</h3>
        <p>Ugeprisen kan variere fra år til år. <a href="'.$this->url('/langekurser/økonomi').'">Læs mere om økonomien</a> i forbindelse med et ophold på Vejle Idrætshøjskole. Du kan søge <a href="'.$this->url('/langekurser/elevstøtte.php').'">elevstøtte</a> som hjælp til at gøre dit ophold billigere.</p>
        <h3>2. Er Vejle Idrætshøjskole for elitefolk?</h3>
        <p>Nej. Vejle Idrætshøjskole er for alle, der kan lide at dyrke idræt og bruge sin krop, men som samtidig gerne vil lære noget om livet.</p>
        <h3>3. Hvordan er jeres alkoholpolitik?</h3>
        <p>Ja, til fest kan man nyde alkohol. Nej, i dagligdagen må du ikke drikke alkohol på skolen. Alkohol og idræt hører ikke sammen. Alkohol nyder vi imidlertid til cafeer og fester, hvor du kan købe øl, vin og breezere.</p>
        <h3>4. Hvor gammel skal man være, og hvad er gennemsnitsalderen?</h3>
        <p>Du skal være 17&frac12; år for at blive indmeldt på en højskole. Gennemsnitsalderen er omkring 21 år, og aldersspredningen er almindeligvis fra 18 år til 35 år.</p>
        <h3>5. Hvad foregår der i fritiden?</h3>
        <p>Der foregår altid noget i fritiden. Enten spirer ideerne og initiativerne, og der er fuld fart på, eller også vælger du at hygge dig med dine kammerater med nogle sjove spil eller en god film. Der er også mulighed for at spille musik, bordfodbold, pool, lave madklubber, eller mere præcist: at være på højskole.</p>
        <h3>6. Kan jeg få en rundvisning på skolen?</h3>
        <p>Ja, det kan du! Du kan blive siddende og kigge på vores <a href="'.$this->url('/faciliteter').'">faciliteter</a>, eller du kan ringe til skolen og aftale et tidspunkt for en rundvisning.</p>
        <h3>7. Har I nogle regler for eleverne?</h3>
        <p>Ja. For at alle kan få det bedst mulige ophold, har vi fire simple forudsætninger, som alle elever skal overholde. Vi har beskrevet forudsætningerne i <a href="'.$this->url('/langekurser/højskoleliv#forudsætninger').'">Jyske Lov</a>.</p>
        <h3>Flere spørgsmål?</h3>
        <p>Hvis du har flere spørgsmål, er du meget velkommen til at <a href="'.$this->url('/kontakt').'">ringe</a> til os, eller du kan <a href="'.$this->url('/kontakt/').'">skrive en e-mail</a>.</p>
        <p>Med venlig hilsen</p>
        <p>Vejle Idrætshøjskole</p>
        ';
    }
}

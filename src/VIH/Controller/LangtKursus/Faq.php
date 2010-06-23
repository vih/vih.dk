<?php
class VIH_Controller_LangtKursus_Faq extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function GET()
    {
        $title = 'Spï¿½rgsmï¿½l og svar om de lange kurser';
        $meta['description'] = 'Ofte stillde spï¿½rgsmï¿½l, spï¿½rgsmï¿½l og svar, frequently asked questions, faq';
        $meta['keywords'] = 'spï¿½rgsmï¿½l, faq, oss, frequently asked questions, svar';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        return '
        <h1>Spï¿½rgsmï¿½l og svar</h1>
        <p>Her har vi forsï¿½gt at samle svarene pï¿½ nogle af de spï¿½rgsmï¿½l, vi ofte bliver stillet.</p>
        <h3>1. Hvad koster et ophold?</h3>
        <p>Ugeprisen kan variere fra ï¿½r til ï¿½r. <a href="'.$this->url('/langekurser/okonomi').'">Lï¿½s mere om ï¿½konomien</a> i forbindelse med et ophold pï¿½ Vejle Idrï¿½tshï¿½jskole. Du kan sï¿½ge <a href="'.url('/langekurser/elevstotte.php').'">elevstï¿½tte</a> som hjï¿½lp til at gï¿½re dit ophold billigere.</p>
        <h3>2. Er Vejle Idrï¿½tshï¿½jskole for elitefolk?</h3>
        <p>Nej. Vejle Idrï¿½tshï¿½jskole er for alle, der kan lide at dyrke idrï¿½t og bruge sin krop, men som samtidig gerne vil lï¿½re noget om livet.</p>
        <h3>3. Hvordan er jeres alkoholpolitik?</h3>
        <p>Ja, til fest kan man nyde alkohol. Nej, i dagligdagen mï¿½ du ikke drikke alkohol pï¿½ skolen. Alkohol og idrï¿½t hï¿½rer ikke sammen. Alkohol nyder vi imidlertid til cafeer og fester, hvor du kan kï¿½be ï¿½l, vin og breezere.</p>
        <h3>4. Hvor gammel skal man vï¿½re, og hvad er gennemsnitsalderen?</h3>
        <p>Du skal vï¿½re 17&frac12; ï¿½r for at blive indmeldt pï¿½ en hï¿½jskole. Gennemsnitsalderen er omkring 21 ï¿½r, og aldersspredningen er almindeligvis fra 18 ï¿½r til 35 ï¿½r.</p>
        <h3>5. Hvad foregï¿½r der i fritiden?</h3>
        <p>Der foregï¿½r altid noget i fritiden. Enten spirer ideerne og initiativerne, og der er fuld fart pï¿½, eller ogsï¿½ vï¿½lger du at hygge dig med dine kammerater med nogle sjove spil eller en god film. Der er ogsï¿½ mulighed for at spille musik, bordfodbold, pool, lave madklubber, eller mere prï¿½cist: at vï¿½re pï¿½ hï¿½jskole.</p>
        <h3>6. Kan jeg fï¿½ en rundvisning pï¿½ skolen?</h3>
        <p>Ja, det kan du! Du kan blive siddende og kigge pï¿½ vores <a href="'.url('/faciliteter').'">faciliteter</a>, eller du kan ringe til skolen og aftale et tidspunkt for en rundvisning.</p>
        <h3>7. Har I nogle regler for eleverne?</h3>
        <p>Ja. For at alle kan fï¿½ det bedst mulige ophold, har vi fire simple forudsï¿½tninger, som alle elever skal overholde. Vi har beskrevet forudsï¿½tningerne i <a href="'.url('/langekurser/hojskoleliv#forudsaetninger').'">Jyske Lov</a>.</p>
        <h3>Flere spï¿½rgsmï¿½l?</h3>
        <p>Hvis du har flere spï¿½rgsmï¿½l, er du meget velkommen til at <a href="'.url('/kontakt').'">ringe</a> til os, eller du kan <a href="'.url('/kontakt/').'">skrive en e-mail</a>.</p>
        <p>Med venlig hilsen</p>
        <p>Vejle Idrï¿½tshï¿½jskole</p>
        ';
    }
}
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
        $title = 'Sp�rgsm�l og svar om de lange kurser';
        $meta['description'] = 'Ofte stillde sp�rgsm�l, sp�rgsm�l og svar, frequently asked questions, faq';
        $meta['keywords'] = 'sp�rgsm�l, faq, oss, frequently asked questions, svar';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        return '
        <h1>Sp�rgsm�l og svar</h1>
        <p>Her har vi fors�gt at samle svarene p� nogle af de sp�rgsm�l, vi ofte bliver stillet.</p>
        <h3>1. Hvad koster et ophold?</h3>
        <p>Ugeprisen kan variere fra �r til �r. <a href="'.$this->url('/langekurser/okonomi').'">L�s mere om �konomien</a> i forbindelse med et ophold p� Vejle Idr�tsh�jskole. Du kan s�ge <a href="'.url('/langekurser/elevstotte.php').'">elevst�tte</a> som hj�lp til at g�re dit ophold billigere.</p>
        <h3>2. Er Vejle Idr�tsh�jskole for elitefolk?</h3>
        <p>Nej. Vejle Idr�tsh�jskole er for alle, der kan lide at dyrke idr�t og bruge sin krop, men som samtidig gerne vil l�re noget om livet.</p>
        <h3>3. Hvordan er jeres alkoholpolitik?</h3>
        <p>Ja, til fest kan man nyde alkohol. Nej, i dagligdagen m� du ikke drikke alkohol p� skolen. Alkohol og idr�t h�rer ikke sammen. Alkohol nyder vi imidlertid til cafeer og fester, hvor du kan k�be �l, vin og breezere.</p>
        <h3>4. Hvor gammel skal man v�re, og hvad er gennemsnitsalderen?</h3>
        <p>Du skal v�re 17&frac12; �r for at blive indmeldt p� en h�jskole. Gennemsnitsalderen er omkring 21 �r, og aldersspredningen er almindeligvis fra 18 �r til 35 �r.</p>
        <h3>5. Hvad foreg�r der i fritiden?</h3>
        <p>Der foreg�r altid noget i fritiden. Enten spirer ideerne og initiativerne, og der er fuld fart p�, eller ogs� v�lger du at hygge dig med dine kammerater med nogle sjove spil eller en god film. Der er ogs� mulighed for at spille musik, bordfodbold, pool, lave madklubber, eller mere pr�cist: at v�re p� h�jskole.</p>
        <h3>6. Kan jeg f� en rundvisning p� skolen?</h3>
        <p>Ja, det kan du! Du kan blive siddende og kigge p� vores <a href="'.url('/faciliteter').'">faciliteter</a>, eller du kan ringe til skolen og aftale et tidspunkt for en rundvisning.</p>
        <h3>7. Har I nogle regler for eleverne?</h3>
        <p>Ja. For at alle kan f� det bedst mulige ophold, har vi fire simple foruds�tninger, som alle elever skal overholde. Vi har beskrevet foruds�tningerne i <a href="'.url('/langekurser/hojskoleliv#forudsaetninger').'">Jyske Lov</a>.</p>
        <h3>Flere sp�rgsm�l?</h3>
        <p>Hvis du har flere sp�rgsm�l, er du meget velkommen til at <a href="'.url('/kontakt').'">ringe</a> til os, eller du kan <a href="'.url('/kontakt/').'">skrive en e-mail</a>.</p>
        <p>Med venlig hilsen</p>
        <p>Vejle Idr�tsh�jskole</p>
        ';
    }
}
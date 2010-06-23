<?php
class VIH_Controller_Hojskole_Index extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function GET()
    {
        $title = 'H�jskole i Vejle - den bedste af alle h�jskoler';
        $meta['description'] = 'H�jskole og h�jskoler: Vejle Idr�tsh�jskole tilbyder forskellige h�jskolekurser. Vi er en h�jskole med idr�tten som samlingspunkt.';
        $meta['keywords'] = 'h�jskole, h�jskoler, idr�tsh�jskoler';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        return '
        <h1>Vilde med idr�t og h�jskole</h1>
        <p><a href="http://vih.dk/">Vejle Idr�tsh�jskole</a> er en af Danmarks mange h�jskoler. Du kan l�se mere om de forskellige h�jskoler p� <a href="http://www.hojskolerne.dk/">hojskolerne.dk</a> eller p� <a href="http://da.wikipedia.org/wiki/Folkeh%C3%B8jskole">Wikipedia</a>.</p>
        <h2>Hvad er en h�jskole?</h2>
        <p>En h�jskole er mange ting. F�lles for alle h�jskoler er h�jskolelivet, som er kendetegnet ved at man undervises p� skolen, spiser p� skolen, sover p� skolen og i det hele taget lever livet p� skolen.</p>
        <h2>Hvor mange h�jskoler findes?</h2>
        <p>Der findes mange h�jskoler i Danmark. Den seneste opdaterede liste finder du p� <a href="http://www.folkehojskoler.dk/">folkehojskoler.dk</a>.</p>
        <h2>Hvad er en idr�tsh�jskole?</h2>
        <p>Det er en h�jskole, der har idr�t som s�rinteresse.</p>
        <h2>Hvor mange idr�tsh�jskoler findes der?</h2>
        <p>Der findes ikke s� mange h�jskoler, hvor idr�tten er det centrale. Hvis du vil se en liste over alle idr�tsh�jskoler i Danmark, kan du klikke forbi <a href="http://www.folkehojskoler.dk/">folkehojskoler.dk</a></p>
        ';
    }
}
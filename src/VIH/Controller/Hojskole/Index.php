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
        $title = 'Hï¿½jskole i Vejle - den bedste af alle hï¿½jskoler';
        $meta['description'] = 'Hï¿½jskole og hï¿½jskoler: Vejle Idrï¿½tshï¿½jskole tilbyder forskellige hï¿½jskolekurser. Vi er en hï¿½jskole med idrï¿½tten som samlingspunkt.';
        $meta['keywords'] = 'hï¿½jskole, hï¿½jskoler, idrï¿½tshï¿½jskoler';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        return '
        <h1>Vilde med idrï¿½t og hï¿½jskole</h1>
        <p><a href="http://vih.dk/">Vejle Idrï¿½tshï¿½jskole</a> er en af Danmarks mange hï¿½jskoler. Du kan lï¿½se mere om de forskellige hï¿½jskoler pï¿½ <a href="http://www.hojskolerne.dk/">hojskolerne.dk</a> eller pï¿½ <a href="http://da.wikipedia.org/wiki/Folkeh%C3%B8jskole">Wikipedia</a>.</p>
        <h2>Hvad er en hï¿½jskole?</h2>
        <p>En hï¿½jskole er mange ting. Fï¿½lles for alle hï¿½jskoler er hï¿½jskolelivet, som er kendetegnet ved at man undervises pï¿½ skolen, spiser pï¿½ skolen, sover pï¿½ skolen og i det hele taget lever livet pï¿½ skolen.</p>
        <h2>Hvor mange hï¿½jskoler findes?</h2>
        <p>Der findes mange hï¿½jskoler i Danmark. Den seneste opdaterede liste finder du pï¿½ <a href="http://www.folkehojskoler.dk/">folkehojskoler.dk</a>.</p>
        <h2>Hvad er en idrï¿½tshï¿½jskole?</h2>
        <p>Det er en hï¿½jskole, der har idrï¿½t som sï¿½rinteresse.</p>
        <h2>Hvor mange idrï¿½tshï¿½jskoler findes der?</h2>
        <p>Der findes ikke sï¿½ mange hï¿½jskoler, hvor idrï¿½tten er det centrale. Hvis du vil se en liste over alle idrï¿½tshï¿½jskoler i Danmark, kan du klikke forbi <a href="http://www.folkehojskoler.dk/">folkehojskoler.dk</a></p>
        ';
    }
}
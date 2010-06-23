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
        $title = 'Højskole i Vejle - den bedste af alle højskoler';
        $meta['description'] = 'Højskole og højskoler: Vejle Idrætshøjskole tilbyder forskellige højskolekurser. Vi er en højskole med idrætten som samlingspunkt.';
        $meta['keywords'] = 'højskole, højskoler, idrætshøjskoler';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        return '
        <h1>Vilde med idræt og højskole</h1>
        <p><a href="http://vih.dk/">Vejle Idrætshøjskole</a> er en af Danmarks mange højskoler. Du kan læse mere om de forskellige højskoler på <a href="http://www.hojskolerne.dk/">hojskolerne.dk</a> eller på <a href="http://da.wikipedia.org/wiki/Folkeh%C3%B8jskole">Wikipedia</a>.</p>
        <h2>Hvad er en højskole?</h2>
        <p>En højskole er mange ting. Fælles for alle højskoler er højskolelivet, som er kendetegnet ved at man undervises på skolen, spiser på skolen, sover på skolen og i det hele taget lever livet på skolen.</p>
        <h2>Hvor mange højskoler findes?</h2>
        <p>Der findes mange højskoler i Danmark. Den seneste opdaterede liste finder du på <a href="http://www.folkehojskoler.dk/">folkehojskoler.dk</a>.</p>
        <h2>Hvad er en idrætshøjskole?</h2>
        <p>Det er en højskole, der har idræt som særinteresse.</p>
        <h2>Hvor mange idrætshøjskoler findes der?</h2>
        <p>Der findes ikke så mange højskoler, hvor idrætten er det centrale. Hvis du vil se en liste over alle idrætshøjskoler i Danmark, kan du klikke forbi <a href="http://www.folkehojskoler.dk/">folkehojskoler.dk</a></p>
        ';
    }
}
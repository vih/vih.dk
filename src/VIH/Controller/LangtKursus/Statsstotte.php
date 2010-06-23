<?php
class VIH_Controller_LangtKursus_Statsstotte extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function GET()
    {
        $title = 'Statsst�tte';
        $meta['description'] = 'L�s mere om, hvordan du f�r �konomisk st�tte til dit h�jskoleophold. Statsst�tten er med til at g�re dit ophold billigere.';
        $meta['keywords'] = 'elevst�tte, billig, rabat, hj�lp, �konomisk';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        return '
        <h1>Statsst�ttemuligheder</h1>
        <p>Staten giver et ekstra tilskud til nedenst�ende grupper, som �nsker at deltage p� et langt h�jskoleophold i mindst 12 uger. Det g�lder:</p>
        <h2>1. Unge som forlod uddannelsessystemet efter 10. klasse</h2>
        <p>Disse unge kan - med et bevis for deres uddannelsesbaggrund - f� en s�rlig rabat p� deres h�jskoleophold. Desuden kan disse unge s� s�ge s�rligt elevtilskud.</p>
        <h2>2. Unge der er indvandrere eller efterkommere af indvandrere</h2>
        <p>Elever, der er indvandret og f�dt i et mindre udviklet tredjeland, eller har for�ldre, der er indvandret og f�dt i mindre udviklet tredjeland, kan f� s�rlig st�tte. Desuden kan disse elever s� s�ge s�rligt elevtilskud. Ved tredjelande menes: Lande i Afrika (alle), Asien (alle - Japan), Mellem- og Sydamerika (alle), Oceanien (alle - Australien og New Zealand) samt nogle lande i Europa (Tyrkiet, Cypern, Georgien og andre gamle sovjetrepublikker �stover med gr�nse mod Asien) (se endvidere bagsiden).</p>
        <h2>3. Unge fra de nye EU - lande</h2>
        <p>Endelig kan der til unge fra de nye EU-lande s�ges s�rlige tilskud til deres ophold gennem CIRIUS ordningen. Ring til Vejle Idr�tsh�jskole p� 7582 0811 for at h�re n�rmere.</p>
        ';

    }

}
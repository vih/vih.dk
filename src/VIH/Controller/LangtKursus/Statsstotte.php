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
        $title = 'Statsstï¿½tte';
        $meta['description'] = 'Læs mere om, hvordan du får økonomisk støtte til dit højskoleophold. Statsstøtten er med til at gøre dit ophold billigere.';
        $meta['keywords'] = 'elevstøtte, billig, rabat, hjælp, økonomisk';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        return '
        <h1>Statsstøttemuligheder</h1>
        <p>Staten giver et ekstra tilskud til nedenstående grupper, som ønsker at deltage på et langt højskoleophold i mindst 12 uger. Det gælder:</p>
        <h2>1. Unge som forlod uddannelsessystemet efter 10. klasse</h2>
        <p>Disse unge kan - med et bevis for deres uddannelsesbaggrund - få en særlig rabat på deres højskoleophold. Desuden kan disse unge så søge særligt elevtilskud.</p>
        <h2>2. Unge der er indvandrere eller efterkommere af indvandrere</h2>
        <p>Elever, der er indvandret og født i et mindre udviklet tredjeland, eller har forældre, der er indvandret og født i mindre udviklet tredjeland, kan få særlig støtte. Desuden kan disse elever så søge særligt elevtilskud. Ved tredjelande menes: Lande i Afrika (alle), Asien (alle - Japan), Mellem- og Sydamerika (alle), Oceanien (alle - Australien og New Zealand) samt nogle lande i Europa (Tyrkiet, Cypern, Georgien og andre gamle sovjetrepublikker østover med grænse mod Asien) (se endvidere bagsiden).</p>
        <h2>3. Unge fra de nye EU - lande</h2>
        <p>Endelig kan der til unge fra de nye EU-lande søges særlige tilskud til deres ophold gennem CIRIUS ordningen. Ring til Vejle Idrætshøjskole på 7582 0811 for at høre nærmere.</p>
        ';

    }

}
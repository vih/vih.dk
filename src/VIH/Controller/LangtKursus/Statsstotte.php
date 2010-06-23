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
        $meta['description'] = 'Lï¿½s mere om, hvordan du fï¿½r ï¿½konomisk stï¿½tte til dit hï¿½jskoleophold. Statsstï¿½tten er med til at gï¿½re dit ophold billigere.';
        $meta['keywords'] = 'elevstï¿½tte, billig, rabat, hjï¿½lp, ï¿½konomisk';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        return '
        <h1>Statsstï¿½ttemuligheder</h1>
        <p>Staten giver et ekstra tilskud til nedenstï¿½ende grupper, som ï¿½nsker at deltage pï¿½ et langt hï¿½jskoleophold i mindst 12 uger. Det gï¿½lder:</p>
        <h2>1. Unge som forlod uddannelsessystemet efter 10. klasse</h2>
        <p>Disse unge kan - med et bevis for deres uddannelsesbaggrund - fï¿½ en sï¿½rlig rabat pï¿½ deres hï¿½jskoleophold. Desuden kan disse unge sï¿½ sï¿½ge sï¿½rligt elevtilskud.</p>
        <h2>2. Unge der er indvandrere eller efterkommere af indvandrere</h2>
        <p>Elever, der er indvandret og fï¿½dt i et mindre udviklet tredjeland, eller har forï¿½ldre, der er indvandret og fï¿½dt i mindre udviklet tredjeland, kan fï¿½ sï¿½rlig stï¿½tte. Desuden kan disse elever sï¿½ sï¿½ge sï¿½rligt elevtilskud. Ved tredjelande menes: Lande i Afrika (alle), Asien (alle - Japan), Mellem- og Sydamerika (alle), Oceanien (alle - Australien og New Zealand) samt nogle lande i Europa (Tyrkiet, Cypern, Georgien og andre gamle sovjetrepublikker ï¿½stover med grï¿½nse mod Asien) (se endvidere bagsiden).</p>
        <h2>3. Unge fra de nye EU - lande</h2>
        <p>Endelig kan der til unge fra de nye EU-lande sï¿½ges sï¿½rlige tilskud til deres ophold gennem CIRIUS ordningen. Ring til Vejle Idrï¿½tshï¿½jskole pï¿½ 7582 0811 for at hï¿½re nï¿½rmere.</p>
        ';

    }

}
<?php
class VIH_Controller_LangtKursus_Elevstotte extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'Elevstï¿½tte';
        $meta['description'] = 'Lï¿½s mere om, hvordan du fï¿½r stï¿½tte til dit hï¿½jskoleophold. Elevstï¿½tten er med til at gï¿½re dit ophold billigere.';
        $meta['keywords'] = 'vejle, idrï¿½tshï¿½jskole, jyske, idrï¿½tsskole, elevstï¿½tte, billig, rabat, hjï¿½lp, ï¿½konomisk, rabatter, tilskud';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        return '
        <h1>Individuel elevstï¿½tte</h1>
        <p>Vejle Idrï¿½tshï¿½jskole rï¿½der over et belï¿½b, som kan sï¿½ges som elevstï¿½tte. Den individuelle elevstï¿½tte kan maksimalt blive 400,- kr. pr. uge. Vi vurderer ansï¿½gningerne inden 14 dage. Dog skal vi have din tilmelding, inden vi tager stilling til din ansï¿½gning.</p>
        <h2 id="hvemtabel">Hvem kan sï¿½ge stï¿½tte?</h2>
        <table summary="Tabel over den individuelle elevstï¿½tte, tilskud, ï¿½konomi">
            <caption>Individuel elevstï¿½tte</caption>
            <thead>
                <tr>
                    <th scope="col" id="hvem">Hvem kan sï¿½ge om stï¿½tte?</th>
                    <th scope="col" id="note">Note</th>
                    <th scope="col" id="tilskud">Max tilskud/uge</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row" headers="hvem">Elever hvis ï¿½konomiske forhold forhindrer et hï¿½jskoleophold</td>
                    <td headers="note">1</td>
                    <td headers="tilskud">400 kr.</td>
                </tr>
                <tr>
                    <td scope="row" headers="hvem">Elever der vï¿½lger 23 uger i forlï¿½ngelse af 18 ugers ophold</td>
                    <td headers="note">2</td>
                    <td headers="tilskud">300 kr.</td>
                </tr>
                <tr>
                    <td scope="row" headers="hvem">Elever, der forud for opholdet har fungeret som ledere, instruktï¿½rer eller trï¿½nere i foreningslivet i mindst &eacute;n sï¿½son.</td>
                    <td headers="note">3</td>
                    <td headers="tilskud">200 kr.</td>
                </tr>
                <tr>
                    <td scope="row" headers="hvem">Elever fra de andre nordiske lande</td>
                    <td headers="note">4</td>
                    <td headers="tilskud">300 kr.</td>
                </tr>
                <tr>
                    <td scope="row" headers="hvem">Elever uden for Norden (rejseudgifter og nedsï¿½ttelse af skolepenge)</td>
                    <td headers="note">5</td>
                    <td headers="tilskud">300 kr.</td>
                </tr>
            </tbody>
        </table>
        <p>Ansï¿½gningsskema kan rekvireres pï¿½ telefon 7582 0811 eller e-mail '.email('kontor@vih.dk') .'.</p>
        <h2 id="kriterier">Uddybende oplysninger om stï¿½tte</h2>
        <p>Puljen skal hjï¿½lpe til: </p>
        <ul>
            <li>at ï¿½konomiske problemer ikke forhindrer interesserede i at gennemfï¿½re et hï¿½jskoleophold </li>
            <li>sikre at skolens elevsammensï¿½tning bliver sï¿½ bred som mulig</li>
        </ul>
        <p>Pï¿½ Vejle Idrï¿½tshï¿½jskole lï¿½gger vi fï¿½lgende kriterier til grund for tildeling:</p>
        <ol>
            <li>En uforudset ï¿½konomisk situation, som betyder, at et planlagt hï¿½jskoleophold mï¿½ opgives, eller at et igangvï¿½rende ophold mï¿½ afbrydes. ï¿½rsagerne kan vï¿½re sygdom, arbejdslï¿½shed, nedgang i lï¿½nindtï¿½gt, dobbelt husleje eller andre uforudsete situationer. For at komme i betragtning til stï¿½tte er det nï¿½dvendigt, at du redegï¿½r for situationen og dine ï¿½konomiske forhold. I det omfang opholdsbetalingen er betinget af forï¿½ldrestï¿½tte, og deres forhold ï¿½ndres vï¿½sentligt, kan dette ogsï¿½ indgï¿½ i begrundelsen. Sammen med ansï¿½gningen om stï¿½tte, bedes du sende dokumentation for, at din bruttoindkomst er faldet vï¿½sentligt (dvs. kopi af lï¿½nsedler, kopi af modtagne dagpengeydelser fra A-kasse. Ved dobbelt husfï¿½relse bedes du sende kopi af huslejekvittering). Du kan evt. blive bedt om anden dokumentation.</li>
            <li>Elever, der ï¿½nsker et 41 ugers kursus (efterï¿½rsskolen + forï¿½rsskolen i forlï¿½ngelse af hinanden), men ikke ser sig istand til at finansiere hele opholdet, kan sï¿½ge om tilskud til nedsï¿½ttelse af elevbetalingen pï¿½ anden del af kurset, nï¿½r sï¿½rlige forhold taler herfor. Stï¿½tten er pï¿½ maksimalt 400,- kr af ugebetalingen i den forlï¿½ngede periode. </li>
            <li>Elever, der inden opholdet har fungeret som ledere, instruktï¿½rer eller trï¿½nere i foreningslivet i mindst &eacute;n sï¿½son, kan tildeles op til 200,- kr pr. uge. Formï¿½let med stï¿½tten er at motivere nuvï¿½rende trï¿½nere til et lï¿½ngerevarende hï¿½jskoleophold af mindst 18 ugers varighed. For at komme i betragtning skal din klubformand fremsende dokumentation og motiveret anbefaling. </li>
            <li>Elever fra de nordiske lande kan fï¿½ stï¿½tte til nedsï¿½ttelse af skolepenge og stï¿½tte til rejseudgifter.</li>
            <li>Elever uden for Norden kan fï¿½ stï¿½tte til nedsï¿½ttelse af skolepenge og stï¿½tte til rejseudgifter.</li>
        </ol>
        <p>Alle ansï¿½gninger bliver behandlet individuelt af skolens forstander. Uanset ovenstï¿½ende kriterier er det udelukkende skolens vurdering, om der ydes individuel elevstï¿½tte. Ansï¿½gninger vurderes fï¿½rst, nï¿½r du er tilmeldt. Der gï¿½res opmï¿½rksom pï¿½, at den individuelle elevstï¿½tte er B-skattepligtig.</p>
        ';
    }
}
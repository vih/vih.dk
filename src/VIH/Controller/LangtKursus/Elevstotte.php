<?php
class VIH_Controller_LangtKursus_Elevstotte extends k_Controller
{
    function GET()
    {
        $title = 'Elevstøtte';
        $meta['description'] = 'Læs mere om, hvordan du får støtte til dit højskoleophold. Elevstøtten er med til at gøre dit ophold billigere.';
        $meta['keywords'] = 'vejle, idrætshøjskole, jyske, idrætsskole, elevstøtte, billig, rabat, hjælp, økonomisk, rabatter, tilskud';

        $this->document->title = $title;
        $this->document->meta = $meta;

        return '
        <h1>Individuel elevstøtte</h1>
        <p>Vejle Idrætshøjskole råder over et beløb, som kan søges som elevstøtte. Den individuelle elevstøtte kan maksimalt blive 400,- kr. pr. uge. Vi vurderer ansøgningerne inden 14 dage. Dog skal vi have din tilmelding, inden vi tager stilling til din ansøgning.</p>
        <h2 id="hvemtabel">Hvem kan søge støtte?</h2>
        <table summary="Tabel over den individuelle elevstøtte, tilskud, økonomi">
            <caption>Individuel elevstøtte</caption>
            <thead>
                <tr>
                    <th scope="col" id="hvem">Hvem kan søge om støtte?</th>
                    <th scope="col" id="note">Note</th>
                    <th scope="col" id="tilskud">Max tilskud/uge</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row" headers="hvem">Elever hvis økonomiske forhold forhindrer et højskoleophold</td>
                    <td headers="note">1</td>
                    <td headers="tilskud">400 kr.</td>
                </tr>
                <tr>
                    <td scope="row" headers="hvem">Elever der vælger 23 uger i forlængelse af 18 ugers ophold</td>
                    <td headers="note">2</td>
                    <td headers="tilskud">300 kr.</td>
                </tr>
                <tr>
                    <td scope="row" headers="hvem">Elever, der forud for opholdet har fungeret som ledere, instruktører eller trænere i foreningslivet i mindst &eacute;n sæson.</td>
                    <td headers="note">3</td>
                    <td headers="tilskud">200 kr.</td>
                </tr>
                <tr>
                    <td scope="row" headers="hvem">Elever fra de andre nordiske lande</td>
                    <td headers="note">4</td>
                    <td headers="tilskud">300 kr.</td>
                </tr>
                <tr>
                    <td scope="row" headers="hvem">Elever uden for Norden (rejseudgifter og nedsættelse af skolepenge)</td>
                    <td headers="note">5</td>
                    <td headers="tilskud">300 kr.</td>
                </tr>
            </tbody>
        </table>
        <p>Ansøgningsskema kan rekvireres på telefon 7582 0811 eller e-mail '.email('kontor@vih.dk') .'.</p>
        <h2 id="kriterier">Uddybende oplysninger om støtte</h2>
        <p>Puljen skal hjælpe til: </p>
        <ul>
            <li>at økonomiske problemer ikke forhindrer interesserede i at gennemføre et højskoleophold </li>
            <li>sikre at skolens elevsammensætning bliver så bred som mulig</li>
        </ul>
        <p>På Vejle Idrætshøjskole lægger vi følgende kriterier til grund for tildeling:</p>
        <ol>
            <li>En uforudset økonomisk situation, som betyder, at et planlagt højskoleophold må opgives, eller at et igangværende ophold må afbrydes. Årsagerne kan være sygdom, arbejdsløshed, nedgang i lønindtægt, dobbelt husleje eller andre uforudsete situationer. For at komme i betragtning til støtte er det nødvendigt, at du redegør for situationen og dine økonomiske forhold. I det omfang opholdsbetalingen er betinget af forældrestøtte, og deres forhold ændres væsentligt, kan dette også indgå i begrundelsen. Sammen med ansøgningen om støtte, bedes du sende dokumentation for, at din bruttoindkomst er faldet væsentligt (dvs. kopi af lønsedler, kopi af modtagne dagpengeydelser fra A-kasse. Ved dobbelt husførelse bedes du sende kopi af huslejekvittering). Du kan evt. blive bedt om anden dokumentation.</li>
            <li>Elever, der ønsker et 41 ugers kursus (efterårsskolen + forårsskolen i forlængelse af hinanden), men ikke ser sig istand til at finansiere hele opholdet, kan søge om tilskud til nedsættelse af elevbetalingen på anden del af kurset, når særlige forhold taler herfor. Støtten er på maksimalt 400,- kr af ugebetalingen i den forlængede periode. </li>
            <li>Elever, der inden opholdet har fungeret som ledere, instruktører eller trænere i foreningslivet i mindst &eacute;n sæson, kan tildeles op til 200,- kr pr. uge. Formålet med støtten er at motivere nuværende trænere til et længerevarende højskoleophold af mindst 18 ugers varighed. For at komme i betragtning skal din klubformand fremsende dokumentation og motiveret anbefaling. </li>
            <li>Elever fra de nordiske lande kan få støtte til nedsættelse af skolepenge og støtte til rejseudgifter.</li>
            <li>Elever uden for Norden kan få støtte til nedsættelse af skolepenge og støtte til rejseudgifter.</li>
        </ol>
        <p>Alle ansøgninger bliver behandlet individuelt af skolens forstander. Uanset ovenstående kriterier er det udelukkende skolens vurdering, om der ydes individuel elevstøtte. Ansøgninger vurderes først, når du er tilmeldt. Der gøres opmærksom på, at den individuelle elevstøtte er B-skattepligtig.</p>
        ';
    }
}
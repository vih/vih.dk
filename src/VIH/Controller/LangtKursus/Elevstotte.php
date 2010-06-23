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
        $title = 'Elevst�tte';
        $meta['description'] = 'L�s mere om, hvordan du f�r st�tte til dit h�jskoleophold. Elevst�tten er med til at g�re dit ophold billigere.';
        $meta['keywords'] = 'vejle, idr�tsh�jskole, jyske, idr�tsskole, elevst�tte, billig, rabat, hj�lp, �konomisk, rabatter, tilskud';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        return '
        <h1>Individuel elevst�tte</h1>
        <p>Vejle Idr�tsh�jskole r�der over et bel�b, som kan s�ges som elevst�tte. Den individuelle elevst�tte kan maksimalt blive 400,- kr. pr. uge. Vi vurderer ans�gningerne inden 14 dage. Dog skal vi have din tilmelding, inden vi tager stilling til din ans�gning.</p>
        <h2 id="hvemtabel">Hvem kan s�ge st�tte?</h2>
        <table summary="Tabel over den individuelle elevst�tte, tilskud, �konomi">
            <caption>Individuel elevst�tte</caption>
            <thead>
                <tr>
                    <th scope="col" id="hvem">Hvem kan s�ge om st�tte?</th>
                    <th scope="col" id="note">Note</th>
                    <th scope="col" id="tilskud">Max tilskud/uge</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row" headers="hvem">Elever hvis �konomiske forhold forhindrer et h�jskoleophold</td>
                    <td headers="note">1</td>
                    <td headers="tilskud">400 kr.</td>
                </tr>
                <tr>
                    <td scope="row" headers="hvem">Elever der v�lger 23 uger i forl�ngelse af 18 ugers ophold</td>
                    <td headers="note">2</td>
                    <td headers="tilskud">300 kr.</td>
                </tr>
                <tr>
                    <td scope="row" headers="hvem">Elever, der forud for opholdet har fungeret som ledere, instrukt�rer eller tr�nere i foreningslivet i mindst &eacute;n s�son.</td>
                    <td headers="note">3</td>
                    <td headers="tilskud">200 kr.</td>
                </tr>
                <tr>
                    <td scope="row" headers="hvem">Elever fra de andre nordiske lande</td>
                    <td headers="note">4</td>
                    <td headers="tilskud">300 kr.</td>
                </tr>
                <tr>
                    <td scope="row" headers="hvem">Elever uden for Norden (rejseudgifter og neds�ttelse af skolepenge)</td>
                    <td headers="note">5</td>
                    <td headers="tilskud">300 kr.</td>
                </tr>
            </tbody>
        </table>
        <p>Ans�gningsskema kan rekvireres p� telefon 7582 0811 eller e-mail '.email('kontor@vih.dk') .'.</p>
        <h2 id="kriterier">Uddybende oplysninger om st�tte</h2>
        <p>Puljen skal hj�lpe til: </p>
        <ul>
            <li>at �konomiske problemer ikke forhindrer interesserede i at gennemf�re et h�jskoleophold </li>
            <li>sikre at skolens elevsammens�tning bliver s� bred som mulig</li>
        </ul>
        <p>P� Vejle Idr�tsh�jskole l�gger vi f�lgende kriterier til grund for tildeling:</p>
        <ol>
            <li>En uforudset �konomisk situation, som betyder, at et planlagt h�jskoleophold m� opgives, eller at et igangv�rende ophold m� afbrydes. �rsagerne kan v�re sygdom, arbejdsl�shed, nedgang i l�nindt�gt, dobbelt husleje eller andre uforudsete situationer. For at komme i betragtning til st�tte er det n�dvendigt, at du redeg�r for situationen og dine �konomiske forhold. I det omfang opholdsbetalingen er betinget af for�ldrest�tte, og deres forhold �ndres v�sentligt, kan dette ogs� indg� i begrundelsen. Sammen med ans�gningen om st�tte, bedes du sende dokumentation for, at din bruttoindkomst er faldet v�sentligt (dvs. kopi af l�nsedler, kopi af modtagne dagpengeydelser fra A-kasse. Ved dobbelt husf�relse bedes du sende kopi af huslejekvittering). Du kan evt. blive bedt om anden dokumentation.</li>
            <li>Elever, der �nsker et 41 ugers kursus (efter�rsskolen + for�rsskolen i forl�ngelse af hinanden), men ikke ser sig istand til at finansiere hele opholdet, kan s�ge om tilskud til neds�ttelse af elevbetalingen p� anden del af kurset, n�r s�rlige forhold taler herfor. St�tten er p� maksimalt 400,- kr af ugebetalingen i den forl�ngede periode. </li>
            <li>Elever, der inden opholdet har fungeret som ledere, instrukt�rer eller tr�nere i foreningslivet i mindst &eacute;n s�son, kan tildeles op til 200,- kr pr. uge. Form�let med st�tten er at motivere nuv�rende tr�nere til et l�ngerevarende h�jskoleophold af mindst 18 ugers varighed. For at komme i betragtning skal din klubformand fremsende dokumentation og motiveret anbefaling. </li>
            <li>Elever fra de nordiske lande kan f� st�tte til neds�ttelse af skolepenge og st�tte til rejseudgifter.</li>
            <li>Elever uden for Norden kan f� st�tte til neds�ttelse af skolepenge og st�tte til rejseudgifter.</li>
        </ol>
        <p>Alle ans�gninger bliver behandlet individuelt af skolens forstander. Uanset ovenst�ende kriterier er det udelukkende skolens vurdering, om der ydes individuel elevst�tte. Ans�gninger vurderes f�rst, n�r du er tilmeldt. Der g�res opm�rksom p�, at den individuelle elevst�tte er B-skattepligtig.</p>
        ';
    }
}
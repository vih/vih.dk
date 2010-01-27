<?php
class VIH_Controller_Info_Organisation extends k_Controller
{
    function GET()
    {
        $title = 'Organisation';
        $meta['description'] = 'En beskrivelse af Vejle Idrætshøjskoles organisation - herunder beslutningsprocedurer.';
        $meta['keywords'] = 'Vejle, Idrætshøjskole, organisation, repræsentantskab, beslutningsprocedure, besluttende organer';

        $this->document->title = $title;
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';

        return '
        <h1>Organisation</h1>
        <p>Vejle Idrætshøjskole er en selvejende institution med følgende hierarkiske opbygning.</p>
        <!--
        <ul>
            <li>Repræsentantskab
            <ul>
                <li>Bestyrelse
                <ul>
                    <li>Forstander
                    <ul>
                        <li>Lærerrådet</li>
                    </ul>
                    </li>
                    <li>Forretningsfører
                    <ul>
                        <li>Medarbejdergrupper</li>
                    </ul>
                    </li>
                    <li>Kursuschef</li>
                </ul>
                </li>
            </ul>
            </li>
        </ul>
        -->
        <h2>Aktører</h2>

        <h3>Repræsentantskabet</h3>

        <p>Skolens øverste myndighed er repræsentantskabet, som holder møde hvert år i marts måned. Repræsentantskabet består af følgende medlemmer:</p>

        <ul>
            <li>Bestyrelsen</li>
            <li>En repræsentant fra hvert af de under Danmarks Idræts-Forbund stående specialforbund</li>
            <li>To repræsentanter fra Danmarks Idræts-Forbund</li>
            <li>To repræsentanter fra De Danske Gymnastik- og Idrætsforeninger</li>
            <li>To repræsentanter fra skolens elevforening</li>
            <li>To repræsentanter fra Samvirkende Idrætsklubber i Vejle</li>
        </ul>

        <h3>Bestyrelsen</h3>

        <p>Bestyrelsen er den overordnede politiske ledelse, som er ansvarlig over for ministeriet. Bestyrelsen består af følgende 5 medlemmer, der vælges blandt repræsentantskabets medlemmer. Repræsentantskabets formand er tillige formand for bestyrelsen, ligesom repræsentantsskabets næstformand også er næstformand for bestyrelsen. Bestyrelsen ansætter og afskediger forstander, forretningsfører, kursuschef og lærere.</p>

        <!--
        <p>Den nuværende bestyrelse ser således ud:</p>

        <table summary="Bestyrelsens sammensætning">
        <caption>Bestyrelsens sammensætning</caption>
        <thead>
            <tr>
                <th scope="col">Formand</th>
                <th scope="col">Næstformand</th>
                <th scope="col">Menigt medlem</th>
                <th scope="col">Menigt medlem</th>
                <th scope="col">Menigt medlem</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Billede følger</td>
                <td>Billede følger</td>
                <td>Billede følger</td>
                <td>Billede følger</td>
                <td>Billede følger</td>
            </tr>
            <tr>
                <td>Poul Grejs Petersen</td>
                <td>Niels Henning Broch-Mikkelsen</td>
                <td>Jens Dall-Hansen</td>
                <td>Ove Jensen</td>
                <td>Carsten Lang Petersen</td>
            </tr>
            <tr>
                <td>Dansk Sejlunion</td>
                <td>Dansk Håndbold Forbund</td>
                <td>Dansk Badmintonforbund</td>
                <td>Dansk Boldspil-Union</td>
                <td>Elevforeningen</td>
            </tr>
        </tbody>
        </table>
        -->
        <h3>Forstander</h3>
        <p>Forstanderen har ansvaret for den daglige ledelse på Vejle Idrætshøjskole. Han sidder med i medarbejderrådet og pædagogisk råd.</p>

        <h3>Forretningsfører</h3>
        <p>Forretningsføreren har det daglige ansvar for administration af højskolen og kursuscenteret. Han er forstanderens højre hånd i økonomiske anliggender. </p>

        <h3>Kursuschef</h3>
        <p>Kursuschefen er daglig leder af kursuscenteret og de korte kurser.</p>

        <h2>Beslutningsproces</h2>
        <p>Beslutningsprocessen afhænger af, hvilken type beslutninger, der skal træffes og af hvilket omfang de er. Forstanderen har det daglige ansvar, men han har uddelegeret beslutninger til fx forretningsfører og kursuschef.</p>
        <p>I hovedreglen forelægges alle spørgsmål og ideer til forstanderen, som tager beslutningen.</p>
        <p>I <strong>større beslutninger</strong> og investeringer træffer  bestyrelsen beslutningerne efter forstanderens indstilling. Medarbejderne har ret til orientering og har udtaleret i beslutningsprocessen.</p>
        <p>I de <strong>daglige mindre beslutninger</strong> har forstanderen det overordnede ansvar, og han uddelegerer nogle beslutninger til sine ansatte.</p>

        ';
    }

}
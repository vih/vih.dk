<?php
class VIH_Controller_Kontakt_Beliggenhed extends k_Controller
{
    function GET()
    {
        $title = 'Beliggenhed, rutebeskrivelse, transport';
        $meta['description'] = 'Beskrivelse af beliggenhed med kørselsvejledning med offentlige transportmidler og med bil fra større indfaldsveje og fra stationen i Vejle.';
        $meta['keywords'] = 'Vejle, idrætshøjskole, jyske, idrætsskole, beliggenhed, kommune, kort, vejbeskrivelse, kørselsvejledning, kørsel, rutebeskrivelse, hvor ligger skolen, placering, kørselsvejvisning, kørselshenvisningormation, transport, indfaldsveje, stationer, station';

        $this->document->title = $title;
        $this->document->meta = $meta;

        return '
            <h1>Beliggenhed</h1>

            <h2>Midt i Danmark</h2>

            <p>Det tager ingen tid at komme til Vejle Idrætshøjskole.</p>

            <p>Vi bor i et af landets smukkeste naturområder, midt i skoven og alligevel kun 3 km fra Vejles rige kulturliv med musikteater, biografer, caf&eacute;er, gallerier og diskoteker. Du kan gå, cykle eller løbe gennem Nørreskoven lige ned til Vejle Fjord.</p>

            <h2>Vejle Kommune</h2>

            <p>Du kan besøge <a href="http://www.vejle.dk/">Vejle Kommunes hjemmeside</a> for at få yderligere oplysninger om, hvad lokalområdet kan byde på.</p>

            <table summary="Sådan finder du skolen med tog, bybus, bil og taxa.">
                <caption>Sådan finder du skolen...</caption>
                <tbody>
                <tr>
                    <th scope="row">... med tog</th>
                    <td>IC-tog direkte til Vejle centrum, hvorfra du kan tage en taxa eller en bybus. Du kan tjekke togtider og bestille billetter på <a href="http://www.dsb.dk/">www.dsb.dk</a>.</td>
                </tr>
                <tr>
                    <th scope="row">... med bybus</th>
                    <td>Der går flere forskellige busser mod Vejle Idrætshøjskole. De kører en til to gange i timen. Du skal med forskellige busnumre alt efter, hvornår du skal med, så for at være sikker på at komme på den rigtige bus, kan du kigge på <a href="http://www.rejseplanen.dk/bin/query.exe/mn?to=Vejle%20Idr%E6tsh%F8jskole">www.rejseplanen.dk</a>. Hvis du er kommet til banegården med tog, skal du huske at billetten også gælder til bussen.</td>
                </tr>
                <tr>
                    <th scope="row">... med bil</th>
                    <td>Drej fra ved motorvejsafkørsel nr. 60 (Vejle Nord). Kør mod centrum. I lyskrydset ved Statoil-tanken, skal du dreje til venstre. Derefter kan du følge skiltene mod Idrætsskolen. Du kan skrive en rutebeskrivelse ud fra <a href="http://www.krak.dk/GRIDS/MAINPAGES/route.asp?Tagning=1.Fir_Fors/FA_RutP">www.krak.dk</a>.</td>
                </tr>
                <tr>
                    <th scope="row">... med taxa</th>
                    <td>Du sætter dig ind i taxaen og siger til chaufføren, at du gerne vil til Vejle Idrætshøjskole på Ørnebjergvej 28. Det koster omkring 70 kroner fra banegården. Du kan bestille en taxa fra Vejle Taxa på 7020 1222 eller fra deres website på <a href="http://www.vejletaxa.dk/">www.vejletaxa.dk</a>.</td>
                </tr>
                <tr>
                    <th scope="row">... med kort</th>
                    <td>Find et <a href="http://www.krak.dk/scripts/kort/krakdk_kortvisning.asp?kk=1122825159&amp;vnr=390551&amp;hnr=28&amp;vejdata=dk_veje">kort</a> over området på <a href="http://www.krak.dk/">Kraks ruteplan</a>.</td>
                </tr>
                </tbody>
            </table>
        ';

    }

}
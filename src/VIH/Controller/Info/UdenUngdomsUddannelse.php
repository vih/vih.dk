<?php
class VIH_Controller_Info_UdenUngdomsUddannelse extends k_Controller
{
    function GET()
    {
        $title = 'Indsats for elever uden ungdomsuddannelse';
        $meta['description'] = '';
        $meta['keywords'] = '';

        $this->document->title = $title;
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';

        return '
        <h1>Indsats for elever uden ungdomsuddannelse</h1>
<p>Unge uden ungdomsuddannelse Støtte til unge som via et højskoleophold indskrevet i deres uddannelsesplan ønsker støtte til at opnå en fremtidig uddannelse.</p>
<p>Indsatsen lægges primært på de som har brug for et løft inden de påbegynder en gymnasial- eller erhvervsuddannelse.</p>
<p>Afklaring og læring er afhængige af faglige, personlige og sociale kompetencer. Med primær fokus på personlige og sociale kompetencer ønsker vi at give deltagerne det løft som sikre at de kan gennemføre fremtidig uddannelsen. Dette ønskes kombineret med et fokus på deltagernes sundhed, som et fundament for øget selvvære og selvtillid.</p>
<p>Forløbet: Følgende områder vil som udgangspunkt indgå for deltagerne uden ungdomsuddannelse. ? Hvilke kompetencer mangler den unge eller ønskes forbedret for at kunne påbegynde og gennemføre en fremtidig uddannelse? ? Hvordan kan de konkrete kompetencer udvikles og hvem kan gøre det? ? Findes der øvrige begrænsninger i forhold til deres muligheder for opstart af uddannelse eller læreplads? ? Opfølgning på indgåede aftaler ? Evaluering og formidling</p>
<p>Vejle Idrætshøjskoles forudsætninger: Vejle Idrætshøjskole har igennem flere år haft struktureret forløb med eksistentiel -og erhvervsrettet vejledning med alle skolens elever. Forløbene har primært været fokuseret på at styrke elevernes sociale og personlige kompetencer. Konkret har hver elev, i opholdets opstartfase, i samarbejde med lærerne fastsat en personlig målsætning for deres ophold. udgangspunktet for målsætningerne er at eleven gennem samtale finder frem til en målsætning som udfordrer netop denne elevs personlighed/personlige kompetencer. Disse målsætninger bliver fuldt op via en midtvejs -og afsluttende samtale og uformel/formel kontakt i hverdagen. Der er i dette forår 12 elever som har søgt kompetencestøtte, altså elever uden ungdomsuddannelse.</p>
<p>Vejle Idrætshøjskole har igennem flere år haft struktureret forløb med eksistentiel -og erhvervsrettet vejledning med alle skolens elever. Forløbene har primært været fokuseret på at styrke elevernes sociale og personlige kompetencer. Konkret har hver elev, i opholdets opstartfase, i samarbejde med lærerne fastsat en personlig målsætning for deres ophold. udgangspunktet for målsætningerne er at eleven gennem samtale finder frem til en målsætning som udfordrer netop denne elevs personlighed/personlige kompetencer. Disse målsætninger bliver fuldt op via en midtvejs -og afsluttende samtale og uformel/formel kontakt i hverdagen.</p>
        ';
    }

}
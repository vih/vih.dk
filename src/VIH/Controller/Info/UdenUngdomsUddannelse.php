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
<p>Unge uden ungdomsuddannelse St�tte til unge som via et h�jskoleophold indskrevet i deres uddannelsesplan �nsker st�tte til at opn� en fremtidig uddannelse.</p>
<p>Indsatsen l�gges prim�rt p� de som har brug for et l�ft inden de p�begynder en gymnasial- eller erhvervsuddannelse.</p>
<p>Afklaring og l�ring er afh�ngige af faglige, personlige og sociale kompetencer. Med prim�r fokus p� personlige og sociale kompetencer �nsker vi at give deltagerne det l�ft som sikre at de kan gennemf�re fremtidig uddannelsen. Dette �nskes kombineret med et fokus p� deltagernes sundhed, som et fundament for �get selvv�re og selvtillid.</p>
<p>Forl�bet: F�lgende omr�der vil som udgangspunkt indg� for deltagerne uden ungdomsuddannelse. ? Hvilke kompetencer mangler den unge eller �nskes forbedret for at kunne p�begynde og gennemf�re en fremtidig uddannelse? ? Hvordan kan de konkrete kompetencer udvikles og hvem kan g�re det? ? Findes der �vrige begr�nsninger i forhold til deres muligheder for opstart af uddannelse eller l�replads? ? Opf�lgning p� indg�ede aftaler ? Evaluering og formidling</p>
<p>Vejle Idr�tsh�jskoles foruds�tninger: Vejle Idr�tsh�jskole har igennem flere �r haft struktureret forl�b med eksistentiel -og erhvervsrettet vejledning med alle skolens elever. Forl�bene har prim�rt v�ret fokuseret p� at styrke elevernes sociale og personlige kompetencer. Konkret har hver elev, i opholdets opstartfase, i samarbejde med l�rerne fastsat en personlig m�ls�tning for deres ophold. udgangspunktet for m�ls�tningerne er at eleven gennem samtale finder frem til en m�ls�tning som udfordrer netop denne elevs personlighed/personlige kompetencer. Disse m�ls�tninger bliver fuldt op via en midtvejs -og afsluttende samtale og uformel/formel kontakt i hverdagen. Der er i dette for�r 12 elever som har s�gt kompetencest�tte, alts� elever uden ungdomsuddannelse.</p>
<p>Vejle Idr�tsh�jskole har igennem flere �r haft struktureret forl�b med eksistentiel -og erhvervsrettet vejledning med alle skolens elever. Forl�bene har prim�rt v�ret fokuseret p� at styrke elevernes sociale og personlige kompetencer. Konkret har hver elev, i opholdets opstartfase, i samarbejde med l�rerne fastsat en personlig m�ls�tning for deres ophold. udgangspunktet for m�ls�tningerne er at eleven gennem samtale finder frem til en m�ls�tning som udfordrer netop denne elevs personlighed/personlige kompetencer. Disse m�ls�tninger bliver fuldt op via en midtvejs -og afsluttende samtale og uformel/formel kontakt i hverdagen.</p>
        ';
    }

}
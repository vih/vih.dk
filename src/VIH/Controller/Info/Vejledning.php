<?php
class VIH_Controller_Info_Vejledning extends k_Controller
{
    function GET()
    {
        $title = 'Vejledning';
        $meta['description'] = '';
        $meta['keywords'] = '';

        $this->document->title = $title;
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';

        return '
<h1>Personlig vejledning i valg af studie og erhvervsretning</h1>
<p>Som elev på Vejle Idrætshøjskole bliver du indplaceret på teams med ca. 8 - 12 elever. Til hvert team er der tilknyttet en kontaktlærer, hvis opgave bl.a. er, at afholde 3 samtaler med dig. Samtalerne afholdes ved begyndelsen, midtvejs og ved afslutningen af dit ophold.</p>

<h2>Formålet med samtalerne er:</h2>
<ol>
<li>at afklare dine forventninger til opholdet</li>
<li>at få indblik i din trivsel undervejs i opholdet</li>
<li>at du lave en personlig målsætning, med formålet at udvikle din personlighed</li>
<li>at give dig muligheden for studie- og erhvervsvejledning.</li>
</ol>
<p>I den første samtalerne vil vi gerne høre lidt om din uddannelsesmæssige baggrund, dine forventninger til opholdet, fremtidsplaner og fastlægge din personlige målsætning.</p>
<p>I midtvejssamtalen følger vi op på den plan, med fremtiden og den personlige målsætning, der blev lagt i den første samtale.</p>
<p>Din afsluttende samtale har til formål at afklare, i hvilken grad dine forventninger/målsætninger med opholdet er blevet indfriet. Desuden følges der op på , om den fremtidsplan der blevet lagt, er kommet godt på vej og kan bæres videre efter opholdet.</p>
<p>Samtalerne er obligatorisk for alle og foregår i en anderledes og mere uformelt stil, end du sikkert er vant til fra tidligere. Derfor er det vigtigt, at du er en interesseret og aktiv medspiller i samtalerne, så der bliver sat fokus på de ting der er vigtig for dig, hvor du er.</p>

';
    }

}

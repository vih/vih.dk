<?php
class VIH_Controller_Info_Om extends k_Controller
{
    function GET()
    {
        $title = 'Om Vejle Idr�tsh�jskole';
        $meta['description'] = 'Vejle Idr�tsh�jskole er en idr�tsh�jskole. H�jskolelivet d�kker over mange ting, det er umuligt at beskrive. Vi har alligevel fors�gt: L�s noget om det her.';
        $meta['keywords'] = 'Vejle, Idr�tsh�jskole, jyske, idr�tsskole, h�jskolekurser, h�jskolekursus, h�jskoleliv, weekend, lovtekster, love, statistik, fortolkning';

        $this->document->title = $title;
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';
        $this->document->theme = 'organisation';

        return '
        <h1>Om Vejle Idr�tsh�jskole</h1>

        <h2>Et sted i bev�gelse</h2>

        <p>Vejle Idr�tsh�jskole er en folkeh�jskole og et kursuscenter. P� h�jskolen har vi idr�tten som hovedinteresse, men vi tilbyder ogs� motion for tankerne. Vores kursuscenter er en moderne konferencevirksomhed med plads til b�de sm� og store kurser - uanset om det er idr�t eller erhverv.</p>

        <h2>Korte og lange kurser</h2>

        <p>I dagligdagen uddanner vi unge mennesker i deres idr�t p� de <a href="'.$this->url('/langekurser/').'">lange h�jskolekurser</a>. De f�r en tr�ner- og instrukt�ruddannelse, s� de har gode foruds�tninger for at undervise i det lokale foreningsliv eller for at forberede sig p� nye udfordringer i livet. Vi optager hvert �r op til 110 elever.</p>

        <p>Vejle Idr�tsh�jskole er et sted for voksne unge. Et fristed fra det trivielle. Et sted med idr�t, gl�de og begejstring. Skolen har <a href="'.$this->url('/underviser/').'">h�jtuddannede undervisere</a> med specialviden inden for deres fagomr�de. </p>

        <p>Sidel�bende med de lange kurser og i sommerperioden kan du opleve <a href="'.$this->url('/kortekurser/') . '">korte kurser</a>: familiekurser, �ldrekurser, golf- og bridgekurser og kurser for udviklingsh�mmede. En eller to ugers intense oplevelser.</p>

        <p>Vi driver h�jskole efter vores <a href="'.$this->url('vaerdigrundlag').'">v�rdigrundlag</a>.</p>

        <h2>Kursuscenter</h2>

        <p>Vejle Idr�tsh�jskole er kursuscenter og h�jskole under samme tag. Vejle Idr�tsh�jskoles kursuscenter henvender sig til b�de idr�ts- og ikke-idr�tslige kurser. </p>

        <h2>Selvst�ndige med forbindelser</h2>

        <p>Vi er selvst�ndige, men med t�t forbindelse til DIF og DIFs specialforbund. Desuden huser vi <a href="http://www.teamdanmark.dk/">Team DANMARKs</a> elitecenter for fodbold.</p>

        <h2>Placering i samfundet</h2>

        <p>Vejle Idr�tsh�jskole er en <a href="'.$this->url('organisation').'">selvejende institution</a> med et selvvalgt <a href="'.$this->url('vaerdigrundlag').'">idegrundlag</a>. Vejle Idr�tsh�jskole er ligesom alle andre folkeh�jskoler p� finansloven, og h�jskolerne h�rer under undervisningsministeriet.</p>

        <h2>Organisation</h2>

        <p>Hvis du er interesseret i vores organisation, har vi lavet en <a href="'.$this->url('organisation').'">organisationsplan</a>.</p>

        <h2>Beliggenhed</h2>

        <p>Hvis du gerne vil finde os, beskriver vi <a href="'.$this->url('beliggenhed').'">hvordan du finder hen til os</a>.</p>

        ';
    }

}
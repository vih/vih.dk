<?php
class VIH_Controller_Info_Om extends k_Controller
{
    function GET()
    {
        $title = 'Om Vejle Idrætshøjskole';
        $meta['description'] = 'Vejle Idrætshøjskole er en idrætshøjskole. Højskolelivet dækker over mange ting, det er umuligt at beskrive. Vi har alligevel forsøgt: Læs noget om det her.';
        $meta['keywords'] = 'Vejle, Idrætshøjskole, jyske, idrætsskole, højskolekurser, højskolekursus, højskoleliv, weekend, lovtekster, love, statistik, fortolkning';

        $this->document->title = $title;
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';
        $this->document->theme = 'organisation';

        return '
        <h1>Om Vejle Idrætshøjskole</h1>

        <h2>Et sted i bevægelse</h2>

        <p>Vejle Idrætshøjskole er en folkehøjskole og et kursuscenter. På højskolen har vi idrætten som hovedinteresse, men vi tilbyder også motion for tankerne. Vores kursuscenter er en moderne konferencevirksomhed med plads til både små og store kurser - uanset om det er idræt eller erhverv.</p>

        <h2>Korte og lange kurser</h2>

        <p>I dagligdagen uddanner vi unge mennesker i deres idræt på de <a href="'.$this->url('/langekurser/').'">lange højskolekurser</a>. De får en træner- og instruktøruddannelse, så de har gode forudsætninger for at undervise i det lokale foreningsliv eller for at forberede sig på nye udfordringer i livet. Vi optager hvert år op til 110 elever.</p>

        <p>Vejle Idrætshøjskole er et sted for voksne unge. Et fristed fra det trivielle. Et sted med idræt, glæde og begejstring. Skolen har <a href="'.$this->url('/underviser/').'">højtuddannede undervisere</a> med specialviden inden for deres fagområde. </p>

        <p>Sideløbende med de lange kurser og i sommerperioden kan du opleve <a href="'.$this->url('/kortekurser/') . '">korte kurser</a>: familiekurser, ældrekurser, golf- og bridgekurser og kurser for udviklingshæmmede. En eller to ugers intense oplevelser.</p>

        <p>Vi driver højskole efter vores <a href="'.$this->url('vaerdigrundlag').'">værdigrundlag</a>.</p>

        <h2>Kursuscenter</h2>

        <p>Vejle Idrætshøjskole er kursuscenter og højskole under samme tag. Vejle Idrætshøjskoles kursuscenter henvender sig til både idræts- og ikke-idrætslige kurser. </p>

        <h2>Selvstændige med forbindelser</h2>

        <p>Vi er selvstændige, men med tæt forbindelse til DIF og DIFs specialforbund. Desuden huser vi <a href="http://www.teamdanmark.dk/">Team DANMARKs</a> elitecenter for fodbold.</p>

        <h2>Placering i samfundet</h2>

        <p>Vejle Idrætshøjskole er en <a href="'.$this->url('organisation').'">selvejende institution</a> med et selvvalgt <a href="'.$this->url('vaerdigrundlag').'">idegrundlag</a>. Vejle Idrætshøjskole er ligesom alle andre folkehøjskoler på finansloven, og højskolerne hører under undervisningsministeriet.</p>

        <h2>Organisation</h2>

        <p>Hvis du er interesseret i vores organisation, har vi lavet en <a href="'.$this->url('organisation').'">organisationsplan</a>.</p>

        <h2>Beliggenhed</h2>

        <p>Hvis du gerne vil finde os, beskriver vi <a href="'.$this->url('beliggenhed').'">hvordan du finder hen til os</a>.</p>

        ';
    }

}
<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_LangtKursus_Hojskole extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'Hvad er et langt højskolekursus?';
        $meta['description'] = 'Vejle Idrætshøjskole er en idrætshøjskole. Højskolelivet dækker over mange ting, det er umuligt at beskrive. Vi har alligevel forsøgt: Læs noget om det her.';
        $meta['keywords'] = 'højskolekurser, højskolekursus, højskoleliv, weekend, rettigheder, pligter';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';

        $data = array('content' => '
        <h1>Hvad er et langt kursus?</h1>

        <p>Et langt højskolekursus på Vejle Idrætshøjskole varer mellem 16 og 41 uger. Du spiser, sover, hygger, bevæger dig, ja, kort sagt lever du på skolen. Der er inspirerende undervisning, cafeaftener med underholdning, fede fester og masser af initiativ og aktivitet i fritiden.</p>
        <p>Du kan se hvilke <a href="'.url('/langekurser/').'">kurser</a> og <a href="fag/">fag</a>, du kan vælge mellem.</p>

        <h2>Højskole - livet i bevægelse</h2>

        <p>Vejle Idrætshøjskole er et sted sted med idræt, glæde og begejstring. Vejle Idrætshøjskole er en folkehøjskole med idræt som hovedinteresse, men vi tilbyder også mange kulturfag, hvor tankerne må på arbejde. Skolen har <a href="'.url('/underviser/').'">højtuddannede undervisere</a> med specialviden inden for deres fagområde og <a href="'.url('/faciliteter/').'">faciliteter</a> til lidt af hvert.</p>

        <h2>Livet er ikke for tilskuere</h2>
        <p>En højskole er ikke for tilskuere, men for medspillere. Vi lærer og lever sammen, og jo mere aktive alle er, des mere opnår vi i fællesskab. Ligesom i alle forhold i livet, må du give lidt for at kunne modtage meget.</p>

        <h2 id="forudsætninger" title="Rettigheder og pligter">Jyske Lov - forudsætninger for at være elev på Vejle Idrætshøjskole</h2>
        <p>For at alle får mest muligt ud af deres højskoleophold, har vi opstillet fire forudsætninger, som eleverne p Vejle Idrætshøjskole skal følge.</p>

        <ol>
            <li>Al undervisning er obligatorisk, og vi forventer at du deltager aktivt i den.</li>
            <li>Brug af doping, hash eller andre euforiserende stoffer er ikke tilladt.</li>
            <li>Alkoholmisbrug må ikke finde sted.</li>
            <li>Du har pligt til at vise hensyn over for andres arbejdsvilkår og trivsel.</li>
        </ol>

        <p>Vi forventer desuden, at du repræsenterer skolen værdigt i den tid, du er elev her. Har du nogle spørgsmål til forudsætningerne, kan du <a href="'.url('/kontakt/').'">ringe til skolen</a> og tale med vores forstander.</p>

        <h2>På kryds og tværs</h2>
        <p>Et højskolekursus på Vejle Idrætshøjskole veksler mellem normaluger og temauger, hvor vi sætter skemaet ud af kraft og arbejder på kryds og tværs. Det betyder ofte, at vi sætter skolen på den anden ende, og at fritimer, aftentimer og weekends bliver inddraget.</p>

        <h2>Et frit fritidsliv!</h2>
        <p>Et dynamisk højskoleliv kræver også et fritidsliv. Du kan fortsætte din foreningsidræt og skabe nye aktiviteter på skolen sammen med dine højskolekammerater.</p>
        ', 'content_sub' => '<h2>Flere højskoler</h2><p>Der er mange forskellige højskoler i Danmark med forskellige specialer.</p><p>Hvis du er interesseret i at læse mere om højskolerne, kan du læse pï¿½ <a href="http://www.leksikon.org/art.php?n=2824">leksikon.org</a> eller på <a href="http://www.hojskolerne.dk/">hojskolerne.dk</a>.</p>');

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }
}
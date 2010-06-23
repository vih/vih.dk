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
        $title = 'Hvad er et langt hï¿½jskolekursus?';
        $meta['description'] = 'Vejle Idrï¿½tshï¿½jskole er en idrï¿½tshï¿½jskole. Hï¿½jskolelivet dï¿½kker over mange ting, det er umuligt at beskrive. Vi har alligevel forsï¿½gt: Lï¿½s noget om det her.';
        $meta['keywords'] = 'hï¿½jskolekurser, hï¿½jskolekursus, hï¿½jskoleliv, weekend, rettigheder, pligter';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';

        $data = array('content' => '
        <h1>Hvad er et langt kursus?</h1>

        <p>Et langt hï¿½jskolekursus pï¿½ Vejle Idrï¿½tshï¿½jskole varer mellem 16 og 41 uger. Du spiser, sover, hygger, bevï¿½ger dig, ja, kort sagt lever du pï¿½ skolen. Der er inspirerende undervisning, cafï¿½aftener med underholdning, fede fester og masser af initiativ og aktivitet i fritiden.</p>
        <p>Du kan se hvilke <a href="'.url('/langekurser/').'">kurser</a> og <a href="fag/">fag</a>, du kan vï¿½lge mellem.</p>

        <h2>Hï¿½jskole - livet i bevï¿½gelse</h2>

        <p>Vejle Idrï¿½tshï¿½jskole er et sted sted med idrï¿½t, glï¿½de og begejstring. Vejle Idrï¿½tshï¿½jskole er en folkehï¿½jskole med idrï¿½t som hovedinteresse, men vi tilbyder ogsï¿½ mange kulturfag, hvor tankerne mï¿½ pï¿½ arbejde. Skolen har <a href="'.url('/underviser/').'">hï¿½jtuddannede undervisere</a> med specialviden inden for deres fagomrï¿½de og <a href="'.url('/faciliteter/').'">faciliteter</a> til lidt af hvert.</p>

        <h2>Livet er ikke for tilskuere</h2>
        <p>En hï¿½jskole er ikke for tilskuere, men for medspillere. Vi lï¿½rer og lever sammen, og jo mere aktive alle er, des mere opnï¿½r vi i fï¿½llesskab. Ligesom i alle forhold i livet, mï¿½ du give lidt for at kunne modtage meget.</p>

        <h2 id="forudsaetninger" title="Rettigheder og pligter">Jyske Lov - forudsï¿½tninger for at vï¿½re elev pï¿½ Vejle Idrï¿½tshï¿½jskole</h2>
        <p>For at alle fï¿½r mest muligt ud af deres hï¿½jskoleophold, har vi opstillet fire forudsï¿½tninger, som eleverne pï¿½ Vejle Idrï¿½tshï¿½jskole skal fï¿½lge.</p>

        <ol>
            <li>Al undervisning er obligatorisk, og vi forventer at du deltager aktivt i den.</li>
            <li>Brug af doping, hash eller andre euforiserende stoffer er ikke tilladt.</li>
            <li>Alkoholmisbrug mï¿½ ikke finde sted.</li>
            <li>Du har pligt til at vise hensyn over for andres arbejdsvilkï¿½r og trivsel.</li>
        </ol>

        <p>Vi forventer desuden, at du reprï¿½senterer skolen vï¿½rdigt i den tid, du er elev her. Har du nogle spï¿½rgsmï¿½l til forudsï¿½tningerne, kan du <a href="'.url('/kontakt/').'">ringe til skolen</a> og tale med vores forstander.</p>

        <h2>Pï¿½ kryds og tvï¿½rs</h2>
        <p>Et hï¿½jskolekursus pï¿½ Vejle Idrï¿½tshï¿½jskole veksler mellem normaluger og temauger, hvor vi sï¿½tter skemaet ud af kraft og arbejder pï¿½ kryds og tvï¿½rs. Det betyder ofte, at vi sï¿½tter skolen pï¿½ den anden ende, og at fritimer, aftentimer og weekends bliver inddraget.</p>

        <h2>Et frit fritidsliv!</h2>
        <p>Et dynamisk hï¿½jskoleliv krï¿½ver ogsï¿½ et fritidsliv. Du kan fortsï¿½tte din foreningsidrï¿½t og skabe nye aktiviteter pï¿½ skolen sammen med dine hï¿½jskolekammerater.</p>
        ', 'content_sub' => '<h2>Flere hï¿½jskoler</h2><p>Der er mange forskellige hï¿½jskoler i Danmark med forskellige specialer.</p><p>Hvis du er interesseret i at lï¿½se mere om hï¿½jskolerne, kan du lï¿½se pï¿½ <a href="http://www.leksikon.org/art.php?n=2824">leksikon.org</a> eller pï¿½ <a href="http://www.hojskolerne.dk/">hojskolerne.dk</a>.</p>');

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }
}
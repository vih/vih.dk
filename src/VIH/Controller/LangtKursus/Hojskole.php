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
        $title = 'Hvad er et langt h�jskolekursus?';
        $meta['description'] = 'Vejle Idr�tsh�jskole er en idr�tsh�jskole. H�jskolelivet d�kker over mange ting, det er umuligt at beskrive. Vi har alligevel fors�gt: L�s noget om det her.';
        $meta['keywords'] = 'h�jskolekurser, h�jskolekursus, h�jskoleliv, weekend, rettigheder, pligter';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';

        $data = array('content' => '
        <h1>Hvad er et langt kursus?</h1>

        <p>Et langt h�jskolekursus p� Vejle Idr�tsh�jskole varer mellem 16 og 41 uger. Du spiser, sover, hygger, bev�ger dig, ja, kort sagt lever du p� skolen. Der er inspirerende undervisning, caf�aftener med underholdning, fede fester og masser af initiativ og aktivitet i fritiden.</p>
        <p>Du kan se hvilke <a href="'.url('/langekurser/').'">kurser</a> og <a href="fag/">fag</a>, du kan v�lge mellem.</p>

        <h2>H�jskole - livet i bev�gelse</h2>

        <p>Vejle Idr�tsh�jskole er et sted sted med idr�t, gl�de og begejstring. Vejle Idr�tsh�jskole er en folkeh�jskole med idr�t som hovedinteresse, men vi tilbyder ogs� mange kulturfag, hvor tankerne m� p� arbejde. Skolen har <a href="'.url('/underviser/').'">h�jtuddannede undervisere</a> med specialviden inden for deres fagomr�de og <a href="'.url('/faciliteter/').'">faciliteter</a> til lidt af hvert.</p>

        <h2>Livet er ikke for tilskuere</h2>
        <p>En h�jskole er ikke for tilskuere, men for medspillere. Vi l�rer og lever sammen, og jo mere aktive alle er, des mere opn�r vi i f�llesskab. Ligesom i alle forhold i livet, m� du give lidt for at kunne modtage meget.</p>

        <h2 id="forudsaetninger" title="Rettigheder og pligter">Jyske Lov - foruds�tninger for at v�re elev p� Vejle Idr�tsh�jskole</h2>
        <p>For at alle f�r mest muligt ud af deres h�jskoleophold, har vi opstillet fire foruds�tninger, som eleverne p� Vejle Idr�tsh�jskole skal f�lge.</p>

        <ol>
            <li>Al undervisning er obligatorisk, og vi forventer at du deltager aktivt i den.</li>
            <li>Brug af doping, hash eller andre euforiserende stoffer er ikke tilladt.</li>
            <li>Alkoholmisbrug m� ikke finde sted.</li>
            <li>Du har pligt til at vise hensyn over for andres arbejdsvilk�r og trivsel.</li>
        </ol>

        <p>Vi forventer desuden, at du repr�senterer skolen v�rdigt i den tid, du er elev her. Har du nogle sp�rgsm�l til foruds�tningerne, kan du <a href="'.url('/kontakt/').'">ringe til skolen</a> og tale med vores forstander.</p>

        <h2>P� kryds og tv�rs</h2>
        <p>Et h�jskolekursus p� Vejle Idr�tsh�jskole veksler mellem normaluger og temauger, hvor vi s�tter skemaet ud af kraft og arbejder p� kryds og tv�rs. Det betyder ofte, at vi s�tter skolen p� den anden ende, og at fritimer, aftentimer og weekends bliver inddraget.</p>

        <h2>Et frit fritidsliv!</h2>
        <p>Et dynamisk h�jskoleliv kr�ver ogs� et fritidsliv. Du kan forts�tte din foreningsidr�t og skabe nye aktiviteter p� skolen sammen med dine h�jskolekammerater.</p>
        ', 'content_sub' => '<h2>Flere h�jskoler</h2><p>Der er mange forskellige h�jskoler i Danmark med forskellige specialer.</p><p>Hvis du er interesseret i at l�se mere om h�jskolerne, kan du l�se p� <a href="http://www.leksikon.org/art.php?n=2824">leksikon.org</a> eller p� <a href="http://www.hojskolerne.dk/">hojskolerne.dk</a>.</p>');

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }
}
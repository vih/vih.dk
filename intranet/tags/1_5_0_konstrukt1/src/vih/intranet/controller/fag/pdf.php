<?php
/**
 * Denne fil skal printe fagbeskrivelser ud som en A4-folder.
 *
 * Forsiden skal indeholde fagnavnet.
 * De to midtersider og bagsiden skal indeholde teksten.
 * Teksten p� under ingen omst�ndigheder l�be over mere end de tre sider.
 *
 * @author Lars Olesen <lars@legestue.net>
 * @require fpdf-library <http://www.fpdf.org>
 *
 * Udskydning skal v�re 4, 1, 2, 3
 *
 * +-----+-----+
 * |     |     |
 * |  3  |  0  |
 * |     |     |
 * +-----+-----+
 * +-----+-----+
 * |     |     |
 * |  1  |  2  |
 * |     |     |
 * +-----+-----+
 *
 * Det er nok en ide at skrive en klasse, der kan lave s�dan et h�fte.
 * Skal sikkert bygges op som en grundklasse, der kan skrive en pdf,
 * og s� lave nogle extends.
 */
class VIH_Intranet_Controller_Fag_Pdf extends k_Controller
{
    function GET()
    {
        $fag = new VIH_Model_Fag($_GET['id']);

        // beskrivelsen skal deles op og regnes ud, hvor meget, der kan v�re p� hver side.
        // det der ikke kan v�re p� midtersiderne skal v�re p� bagsiden.

        $pdf = new VIH_PdfBrochure();
        $pdf->SetTitle($fag->get('navn'));
        $pdf->SetSubject('Fagbeskrivelse: ' . $fag->get('navn'));
        $pdf->SetAuthor('Lars Olesen, Vejle Idr�tsh�jskole');
        $pdf->SetCreator('Lars Olesen, Vejle Idr�tsh�jskole');
        $pdf->SetDisplayMode('fullpage', 'two');
        $pdf->SetKeywords('keyword');
        $pdf->VIHContent($fag->get('beskrivelse'));
        $pdf->Output();
    }
}

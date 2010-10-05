<?php
/**
 * Class VIH_PdfBrochure
 * Description: Danner pdf-brochure.
 *
 * Benyttes s�lede:
 * $pdf = new VIH_PdfBrochure();
 * $pdf->SetTitle($fag->get('navn')); // Dette kommer ogs� til at st� p� forsiden af brochuren
 * $pdf->SetSubject('Fagbeskrivelse: ' . $fag->get('navn'));
 * $pdf->SetAuthor('Lars Olesen, Vejle Idr�tsh�jskole');
 * $pdf->SetCreator('Lars Olesen, Vejle Idr�tsh�jskole');
 * $pdf->SetDisplayMode('fullpage', 'two');
 * $pdf->SetKeywords('keyword');
 * $pdf->VIHContent($fag->get('beskrivelse'));
 * $pdf->Output();
 *
 * Indstillinger s�ttes i funktionen VIH_PdfBrochure. Se ogs�
 * Desuden kan formatering af html-tags �ndres i funktionen htmlParserOpen
 *
 * Author: Sune Jensen sj@sunet.dk
 * Date: 20/2 2006
 **/

require_once 'fpdf/fpdf.php';
require_once 'XML/XML_HTMLSax.php';

class VIH_PdfBrochure extends FPDF
{
    var $column; // kolonnenummer
    var $vih_outer_margin;
    var $vih_inner_margin;
    var $vih_top_margin;
    var $vih_bottom_margin;

    var $vih_font_family;
    var $vih_font_size;
    var $vih_line_spacing;

    var $vih_frontpage_font_size;
    var $vih_frontpage_top_margin;

    var $html_parser;

    function __construct()
    {
        $this->FPDF("L");

        $this->vih_outer_margin = 10; // margin til kant af papiret
        $this->vih_inner_margin = 10; // margin til til midten af papiret mellem de 2 kolonner
        $this->vih_top_margin = 40;
        $this->vih_bottom_margin = 20;

        $this->vih_font_family = 'Arial';
        $this->vih_font_size = 10;
        $this->vih_line_spacing = 4;

        $this->vih_frontpage_font_size = 25;
        $this->vih_frontpage_top_margin = 100; // afstand ned til titlen p� forsiden

    }

    function VIHContent($fagbeskrivelse)
    {
        $this->SetAutoPageBreak(1, $this->vih_bottom_margin);
        $this->setTopMargin($this->vih_top_margin);

        $this->addPage();
        $this->SetFont($this->vih_font_family,'',$this->vih_font_size);
        $this->setColumn(1);

        // Inds�t fagbeskrivelse i html-format. Se HTMLParseOpen for mulige tags.
        $this->parseHTML($fagbeskrivelse);

        // S�rger for vi kommer til forsiden.
        if ($this->column == 1 || $this->column == 2) {
            $this->addPage();
            $this->setColumn(0);
        } elseif ($this->column == 3) {
            $this->setColumn(0);
        }

        $this->setY($this->vih_frontpage_top_margin);
        $this->SetFont($this->vih_font_family,'B',$this->vih_frontpage_font_size);
        $this->MultiCell(0, 10, $this->title, 0, 'C');

        // Til sidst skal siderne byttes rundt, s� forsiden kommer p� den f�rste af de to sider
        $old_pages = $this->pages;
        $this->pages[1] = $old_pages[2];
        $this->pages[2] = $old_pages[1];

    }

    function SetColumn($col)
    {
        //Move position to a column
        $this->column = $col;

        switch($this->column) {
            case 1:
            case 3:
                $left = $this->vih_outer_margin;
                // $this->fh: dokument bredde (betyder format height, men da papiret l�gges ned, vendes skiftes variablerne ikke).
                $right = $this->vih_outer_margin + ($this->fh - $this->vih_outer_margin * 2 - $this->vih_inner_margin * 2)/2 + $this->vih_inner_margin * 2;
                break;
            case 0:
            case 2:
                $left = $this->vih_outer_margin + ($this->fh - $this->vih_outer_margin * 2 - $this->vih_inner_margin * 2)/2 + $this->vih_inner_margin * 2;
                $right = $this->vih_outer_margin;
                break;
            default:
                die("Der kan kun v�re kolonne 0 til 3");
            break;
        }

        $this->SetLeftMargin($left);
        $this->SetRightMargin($right);

      $this->SetX($left);
    }

    function AcceptPageBreak()
    {

        switch($this->column) {
            case 1:
                $this->SetColumn(2);
                $this->SetY($this->vih_top_margin);
                $return = false;
                break;
            case 3:
                $this->setColumn(0);
                $this->SetY($this->vih_top_margin);
                $return = false;
                break;
            case 0:
                die("Der er for meget tekst til, at det kan v�re i brochuren");
                break;
            case 2:
                $this->SetColumn(3);
                $return = true;
                break;
            default:
                die("ugyldig kolonnenummer");
                break;
        }

        return $return;

    }

    function parseHTML($html)
    {
        $this->html_parser =& new XML_HTMLSax();
        $this->html_parser->set_object($this);
        $this->html_parser->set_element_handler('htmlParserOpen', 'htmlParserClose');
        $this->html_parser->set_data_handler('htmlParserData');

        $this->html_parser->parse($html);
    }

    function htmlParserData($parser, $data)
    {
        $this->Write($this->vih_line_spacing, $data);
        // $this->MultiCell(0, $this->vih_line_spacing, $data, 0, "L");
        // echo 'Character data: '.$data;
    }

    function htmlParserOpen($parser, $tag)
    {
        switch($tag) {
            case "h2":
                $this->SetFont($this->vih_font_family,'B',$this->vih_font_size + 4);
                break;
            case "h3":
                $this->SetFont($this->vih_font_family,'B',$this->vih_font_size + 2);
                break;
            case "h4":
                $this->SetFont($this->vih_font_family,'B',$this->vih_font_size);
                break;
             case "strong":
                 $this->SetFont($this->vih_font_family,'B',$this->vih_font_size);
                break;
            case "em":
                $this->SetFont($this->vih_font_family,'I',$this->vih_font_size);
                break;
            default:
                $this->SetFont($this->vih_font_family,'',$this->vih_font_size);
                break;
        }
        // $this->SetFont($this->vih_font_family,'B',20);
        // echo 'Opening Tag: '.$tag;
    }

    function htmlParserClose($parser, $tag)
    {
        switch($tag) {
            case "h2":
            case "h3":
            case "h4":
            case "strong":
            case "em":
            default:
                $this->SetFont($this->vih_font_family,'',$this->vih_font_size);
                break;
        }
    }
}
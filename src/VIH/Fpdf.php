<?php
require_once 'fpdf.php';

class VIH_Fpdf extends FPDF
{
    function footer()
    {
        //Go to 1.5 cm from bottom
        $this->SetY(-20);
        //Select Arial italic 8
        $this->SetFont('Arial','I',8);
        //Print centered page number
        $this->Cell(0, 10 , 'Side ' . $this->PageNo()." af {nb}", 0, 0, 'R');
        return true;
    }

    function setY($value)
    {
        if ($value > 0 && $value > $this->h - 30) {
            $this->addPage();
        } else {
            parent::setY($value);
        }
    }

    function Cell($w = '', $h = '', $text = '', $border = '', $ln  = '', $align  = '', $fill  = '', $link = '')
    {
        $text = utf8_decode($text);
        return parent::Cell($w, $h, $text, $border, $ln, $align, $fill, $link);
    }

    function GetStringWidth($string)
    {
        $string = utf8_decode($string);
        return parent::GetStringWidth($string);
    }

    function Text($x, $y, $txt)
    {
        $txt = utf8_decode($txt);
        return parent::Text($x, $y, $txt);
    }
}

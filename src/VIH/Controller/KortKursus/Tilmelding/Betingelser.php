<?php
class VIH_Controller_KortKursus_Tilmelding_Betingelser extends k_Component
{
    function renderHtml()
    {
        $this->document->setTitle('Betalings- og forsikringsbetingelser');
        return '
        <h1>Betingelser</h1>

        <p><a href="'.$this->url('../confirm').'">Tilbage</a></p>

        <h3>Betaling</h3>

        <p><strong>Tilmeldingsdepositum</strong> indbetales samtidig med indsendelse af tilmeldingsblanketten. Tilmeldingsdepositummet tilbagebetales ikke ved framelding med mindre man har tegnet en afbestillingsforsikring hos Vejle Idr�tsh�jskole.</p>
        <p><strong>Det resterende bel�b</strong> (kursuspris minus tilmeldingsdepositum) indbetales senest 6 uger f�r kursusstart.</p>

        <p>Alle bel�b er danske kroner.</p>

        <h3>Betalingsformer</h3>

        <p>Du kan betale p� en af f�lgende m�der:</p>

        <ul>
            <li>Overf�re pengene til kontonummer <strong>7244-1469664</strong></li>
            <li>Dankort <img src="'.$this->url('/gfx/icons/dankort.jpg').'" alt="Dankort" /></li>
        </ul>

        <h3>Framelding</h3>

        <h4>Vejle Idr�tsh�jskoles afbestillingsforsikring</h4>

        <p>En afbestillingsforsikring koster ' . KORTEKURSER_STANDARDPRISER_AFBESTILLINGSFORSIKRING . ' kr pr. person og skal bestilles og betales i forbindelse med tilmeldingen (husk at s�tte kryds for forsikring p� tilmeldingsblanketten).</p>

        <ul>
            <li>Forsikringen skal tegnes og betales ved tilmelding (kan ikke efterbestilles).</li>
            <li>Ved afbud refunderes hele det indbetalte kursusbel�b (p� n�r forsikringspr�mien).</li>
        </ul>

        <h4>Framelding uden forsikring</h4>
        <ul>
            <li>Ved framelding inden 14 dage f�r kursusstart f�r man kursusprisen retur p� n�r tilmeldingsdepositummet.</li>
            <li>Ved framelding senere end 14 dage f�r kursusstart er kursusbel�bet tabt.</li>
        </ul>

        <h3>Kontakt</h3>
        <p>
        Vejle Idr�tsh�jskole
        <br />�rnebjergvej 28
        <br />7100 Vejle
        <br />Telefon: 75820811
        <br />E-mail: kontor@vih.dk
        <br />CVR: 36850728
        </p>
        ';

    }
}

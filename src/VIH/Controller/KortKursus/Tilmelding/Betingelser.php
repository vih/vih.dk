<?php
class VIH_Controller_KortKursus_Tilmelding_Betingelser extends k_Controller
{
    function GET()
    {
        $this->document->title = 'Betalings- og forsikringsbetingelser';
        return '
        <h1>Betingelser</h1>

        <p><a href="'.$this->url('../confirm').'">Tilbage</a></p>

        <h3>Betaling</h3>

        <p><strong>Tilmeldingsdepositum</strong> indbetales samtidig med indsendelse af tilmeldingsblanketten. Tilmeldingsdepositummet tilbagebetales ikke ved framelding med mindre man har tegnet en afbestillingsforsikring hos Vejle Idrætshøjskole.</p>
        <p><strong>Det resterende beløb</strong> (kursuspris minus tilmeldingsdepositum) indbetales senest 6 uger før kursusstart.</p>

        <p>Alle beløb er danske kroner.</p>

        <h3>Betalingsformer</h3>

        <p>Du kan betale på en af følgende måder:</p>

        <ul>
            <li>Overføre pengene til kontonummer <strong>7244-1469664</strong></li>
            <li>Dankort <img src="'.$this->url('/gfx/icons/dankort.jpg').'" alt="Dankort" /></li>
        </ul>

        <h3>Framelding</h3>

        <h4>Vejle Idrætshøjskoles afbestillingsforsikring</h4>

        <p>En afbestillingsforsikring koster ' . KORTEKURSER_STANDARDPRISER_AFBESTILLINGSFORSIKRING . ' kr pr. person og skal bestilles og betales i forbindelse med tilmeldingen (husk at sætte kryds for forsikring på tilmeldingsblanketten).</p>

        <ul>
            <li>Forsikringen skal tegnes og betales ved tilmelding (kan ikke efterbestilles).</li>
            <li>Ved afbud refunderes hele det indbetalte kursusbeløb (på nær forsikringspræmien).</li>
        </ul>

        <h4>Framelding uden forsikring</h4>
        <ul>
            <li>Ved framelding inden 14 dage før kursusstart får man kursusprisen retur på nær tilmeldingsdepositummet.</li>
            <li>Ved framelding senere end 14 dage før kursusstart er kursusbeløbet tabt.</li>
        </ul>

        <h3>Kontakt</h3>
        <p>
        Vejle Idrætshøjskole
        <br />Ørnebjergvej 28
        <br />7100 Vejle
        <br />Telefon: 75820811
        <br />E-mail: kontor@vih.dk
        <br />CVR: 36850728
        </p>
        ';

    }
}

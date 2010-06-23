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

        <p><strong>Tilmeldingsdepositum</strong> indbetales samtidig med indsendelse af tilmeldingsblanketten. Tilmeldingsdepositummet tilbagebetales ikke ved framelding med mindre man har tegnet en afbestillingsforsikring hos Vejle Idrï¿½tshï¿½jskole.</p>
        <p><strong>Det resterende belï¿½b</strong> (kursuspris minus tilmeldingsdepositum) indbetales senest 6 uger fï¿½r kursusstart.</p>

        <p>Alle belï¿½b er danske kroner.</p>

        <h3>Betalingsformer</h3>

        <p>Du kan betale pï¿½ en af fï¿½lgende mï¿½der:</p>

        <ul>
            <li>Overfï¿½re pengene til kontonummer <strong>7244-1469664</strong></li>
            <li>Dankort <img src="'.$this->url('/gfx/icons/dankort.jpg').'" alt="Dankort" /></li>
        </ul>

        <h3>Framelding</h3>

        <h4>Vejle Idrï¿½tshï¿½jskoles afbestillingsforsikring</h4>

        <p>En afbestillingsforsikring koster ' . KORTEKURSER_STANDARDPRISER_AFBESTILLINGSFORSIKRING . ' kr pr. person og skal bestilles og betales i forbindelse med tilmeldingen (husk at sï¿½tte kryds for forsikring pï¿½ tilmeldingsblanketten).</p>

        <ul>
            <li>Forsikringen skal tegnes og betales ved tilmelding (kan ikke efterbestilles).</li>
            <li>Ved afbud refunderes hele det indbetalte kursusbelï¿½b (pï¿½ nï¿½r forsikringsprï¿½mien).</li>
        </ul>

        <h4>Framelding uden forsikring</h4>
        <ul>
            <li>Ved framelding inden 14 dage fï¿½r kursusstart fï¿½r man kursusprisen retur pï¿½ nï¿½r tilmeldingsdepositummet.</li>
            <li>Ved framelding senere end 14 dage fï¿½r kursusstart er kursusbelï¿½bet tabt.</li>
        </ul>

        <h3>Kontakt</h3>
        <p>
        Vejle Idrï¿½tshï¿½jskole
        <br />ï¿½rnebjergvej 28
        <br />7100 Vejle
        <br />Telefon: 75820811
        <br />E-mail: kontor@vih.dk
        <br />CVR: 36850728
        </p>
        ';

    }
}

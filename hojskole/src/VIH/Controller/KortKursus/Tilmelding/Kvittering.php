<?php
/**
 * Denne side skal skrive en kvittering til kunden og sende en e-mailbekræftelse
 * på alt kunden har lavet i tilmeldingssystemet.
 *
 * @author Lars Olesen <lars@legestue.net>
 */

class VIH_Controller_KortKursus_Tilmelding_Kvittering extends k_Controller
{
    function GET()
    {
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($this->context->name);

        if (!$tilmelding->get('id') OR !$tilmelding->get('navn')) {
            throw new Exception('Du har ikke ret til at være her');
        }

        $tilmelding->loadBetaling();

        $this->document->title = 'Kvittering';

        $deltagere_data = array('deltagere' => $tilmelding->getDeltagere(),
                                'type' => $tilmelding->get('keywords'),
                                'indkvartering' => $tilmelding->kursus->get('indkvartering'),
                                'kursus' => $tilmelding->kursus);

        $oplysninger_data = array('caption' => 'Tilmeldingsoplysninger',
                                  'tilmelding' => $tilmelding);

        $prisoversigt_data = array('tilmelding' => $tilmelding);

        $betaling_data = array('login_uri' => $this->url('/login/kortekurser/' . $tilmelding->get('code')),
                               'tilmelding' => $tilmelding);

        $afbestillingsforsikring = '';
        if ($tilmelding->get('afbestillingsforsikring') == 'Ja') {
            $afbestillingsforsikring = ' og ' . $tilmelding->get('pris_forsikring') . ' kroner i forsikringspræmie';
        }

        if ($tilmelding->get('dato_forfalden') <= date('Y-m-d')) {
            $what_to_do = '
                <ul>
                    <li><strong>betalt ' . $tilmelding->get('skyldig') . ' kroner</strong> som hele det skyldige beløb.</li>
                    <li><strong>modtaget bekræftelse</strong>. Den sender vi, når vi har modtaget pengene.</li>
                </ul>
            ';
        } else {
            $what_to_do = '
                <ul>
                    <li><strong>betalt ' . $tilmelding->get('skyldig_depositum') . ' kroner</strong> som dækker ' .  $tilmelding->get('pris_depositum') . ' kroner i    tilmeldingsdepositum'.$afbestillingsforsikring.'.</li>
                    <li><strong>modtaget bekræftelse</strong>. Den sender vi, når vi har modtaget tilmeldingsdepositummet.</li>
                </ul>
            ';
        }

        $this->SESSION->destroy();
        $this->SESSION->regenerateId();
        $tilmelding->confirm();

        return '
            <h1>Bekræftelse på reservation</h1>
            <p>Foreløbig har du reserveret en plads. Din reservation gælder i otte dage. Du er først tilmeldt kurset, når du har gjort følgende:</p>' .
            $what_to_do . $this->render('VIH/View/KortKursus/Tilmelding/oplysninger-tpl.php', $oplysninger_data) . $this->render('VIH/View/KortKursus/Tilmelding/prisoversigt-tpl.php', $prisoversigt_data) . $this->render('VIH/View/KortKursus/Tilmelding/deltagere-tpl.php', $deltagere_data) .'

            <h2>Betaling</h2>
            '.$this->render('VIH/View/Tilmelding/betaling-tpl.php', $betaling_data).'

            <h2>Program og yderligere oplysninger</h2>
            <p>Kursusprogrammet sendes cirka to uger før kursusstart. Hvis du har nogen spørgsmål, er du meget velkommen enten til at ringe til os eller skrive en e-mail.</p>
            <ul class="options">
                <li><a href="'.$this->url('../close').'">Luk tilmeldingen og gå tilbage til forsiden</a></li>
            </ul>
        ';

    }
}

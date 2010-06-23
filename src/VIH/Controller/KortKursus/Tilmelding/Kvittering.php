<?php
/**
 * Denne side skal skrive en kvittering til kunden og sende en e-mailbekr�ftelse
 * p� alt kunden har lavet i tilmeldingssystemet.
 *
 * @author Lars Olesen <lars@legestue.net>
 */

class VIH_Controller_KortKursus_Tilmelding_Kvittering extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function dispatch()
    {
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($this->context->name());

        if (!$tilmelding->get('id') OR !$tilmelding->get('navn')) {
            throw new Exception('Du har ikke ret til at v�re her');
        }

        return parent::dispatch();
    }

    function GET()
    {
        $tilmelding = new VIH_Model_KortKursus_OnlineTilmelding($this->context->name());

        $tilmelding->loadBetaling();

        $this->document->setTitle('Kvittering');

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
            $afbestillingsforsikring = ' og ' . $tilmelding->get('pris_forsikring') . ' kroner i forsikringspr�mie';
        }

        if ($tilmelding->get('dato_forfalden') <= date('Y-m-d')) {
            $what_to_do = '
                <ul>
                    <li><strong>betalt ' . $tilmelding->get('skyldig') . ' kroner</strong> som hele det skyldige bel�b.</li>
                    <li><strong>modtaget bekr�ftelse</strong>. Den sender vi, n�r vi har modtaget pengene.</li>
                </ul>
            ';
        } else {
            $what_to_do = '
                <ul>
                    <li><strong>betalt ' . $tilmelding->get('skyldig_depositum') . ' kroner</strong> som d�kker ' .  $tilmelding->get('pris_depositum') . ' kroner i    tilmeldingsdepositum'.$afbestillingsforsikring.'.</li>
                    <li><strong>modtaget bekr�ftelse</strong>. Den sender vi, n�r vi har modtaget tilmeldingsdepositummet.</li>
                </ul>
            ';
        }

        $this->session()->destroy();
        $this->session()->regenerateId();
        $tilmelding->confirm();

        $betal_tpl = $this->template->create('Tilmelding/betaling');
        $opl_tpl = $this->template->create('KortKursus/Tilmelding/oplysninger');
        $pris_tpl = $this->template->create('KortKursus/Tilmelding/prisoversigt');
        $delt_tpl = $this->template->create('KortKursus/Tilmelding/deltagere');

        return '
            <h1>Bekr�ftelse p� reservation</h1>
            <p>Forel�big har du reserveret en plads. Din reservation g�lder i otte dage. Du er f�rst tilmeldt kurset, n�r du har gjort f�lgende:</p>' .
            $what_to_do . $opl_tpl->render($this, $oplysninger_data) . $pris_tpl->render($this, $prisoversigt_data) . $delt_tpl->render($this, $deltagere_data) .'

            <h2>Betaling</h2>
            '.$betal_tpl->render($this, $betaling_data).'

            <h2>Program og yderligere oplysninger</h2>
            <p>Kursusprogrammet sendes cirka to uger f�r kursusstart. Hvis du har nogen sp�rgsm�l, er du meget velkommen enten til at ringe til os eller skrive en e-mail.</p>
            <ul class="options">
                <li><a href="'.$this->url('../close').'">Luk tilmeldingen og g� tilbage til forsiden</a></li>
            </ul>
        ';

    }
}

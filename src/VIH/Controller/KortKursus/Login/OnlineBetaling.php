<?php
/**
 * Dankortbetaling
 *
 * Her kan man betale med Dankort for et kort kursus.
 *
 * @see /betaling/Betaling.php
 */
class VIH_Controller_KortKursus_Login_OnlineBetaling extends k_Controller
{
    private $form;
    protected $extra_text;

    function GET()
    {
        $tilmelding = VIH_Model_KortKursus_Tilmelding::factory($this->context->name);
        $tilmelding->loadBetaling();

        // der skal lige laves noget i Tilmelding.php, så vi har styr over hvor meget der mangler at blive betalt med de afventendede betalinger
        if (count($tilmelding->betaling->getList('not_approved')) > 0) {
            $this->extra_text = '<p id="notice"><strong>Advarsel</strong>: Vær opmærksom på, at du har afventende betalinger på '.$tilmelding->get('betalt_not_approved').' kroner. Du skal altså kun bruge formularen, hvis du er helt sikker på, at du skal betale beløbene nedenunder.</p>';
        }

        $error = "";

        $this->document->title = 'Betaling med dankort';

        $data = array(
            'tilmelding' => $tilmelding,
            'course_type' => 'korte',
            'extra_text' => $this->extra_text
        );

        return $this->render('VIH/View/Kundelogin/onlinebetaling-tpl.php', $data);
    }

    function POST()
    {
        $tilmelding = VIH_Model_KortKursus_Tilmelding::factory($this->context->name);
        if ($this->getForm()->validate()) {
            // først skal vi oprette en betaling - som kan fungere som id hos qp
            // betalingen skal kobles til den aktuelle tilmelding
            // når vi så har haft den omkring pbs skal betalingen opdateres med status for betalingen
            // status sættes til 000, hvis den er godkendt hos pbs.

            $eval = false;

            $betaling = new VIH_Model_Betaling("kortekurser", $tilmelding->get("id"));

            $betaling_amount = $this->POST['amount']/100;
            $betaling_id = $betaling->save(array('type' => 'quickpay', 'amount' => $betaling_amount));
            if ($betaling_id == 0) {
                throw new Exception("Kunne ikke oprette betaling");
            }

            $onlinebetaling = new VIH_Onlinebetaling('authorize');
            $onlinebetaling->addCustomVar("Kursusnavn", "Kortkursus: ".$tilmelding->kursus->getKursusNavn());
            $onlinebetaling->addCustomVar("Kontaktnavn", $tilmelding->get("navn"));
            $onlinebetaling->addCustomVar("Tilmelding_ID", $tilmelding->get("id"));
            $eval = $onlinebetaling->authorize(
                $this->POST['cardnumber'], // kortnummer
                $this->POST['yy'] . $this->POST['mm'], //YYMM
                $this->POST['cvd'], // sikkerhedsnummer
                $betaling_id, // ordrenummer
                $this->POST['amount']    // beløb
            );

            if ($eval) {
                if ($eval['qpstat'] === '000') {
                    // The authorization was completed
                    /*
                    echo "<pre>";
                    var_dump($eval);
                    echo "</pre>";
                    */
                    $betaling->setTransactionnumber($eval['transaction']);
                    $betaling->setStatus('completed');

                    $historik = new VIH_Model_Historik($betaling->get('belong_to'), $betaling->get('belong_to_id'));
                    if (!$historik->save(array('betaling_id' => $betaling->get('id'), 'type' => 'dankort', 'comment' => 'Onlinebetaling # ' . $betaling->get('transactionnumber')))) {
                        trigger_error('Der var en fejl med at gemme historikken.', E_USER_ERROR);
                    }

                    throw new k_http_Redirect($this->context->url());
                } else {
                    // An error occured with the authorize

                    $this->extra_text = '<p class="warning">Der opstod en fejl under transaktionen. '.$onlinebetaling->statuskoder[$eval['qpstat']].'. Du kan prøve igen.</p>';
                    /*
                    echo "<pre>";
                    var_dump($eval);
                    echo "</pre>";
					*/
                }
            } else {
                $this->extra_text = 'Kommunikationsfejl med PBS eller QuickPay';
            }
        }
        return $this->GET();
    }

    function getForm()
    {
        if ($this->form) {
            return $this->form;
        }
        $tilmelding = VIH_Model_KortKursus_Tilmelding::factory($this->context->name);
        $tilmelding->loadBetaling();

        $forsikringstekst = '';
        if ($tilmelding->get('pris_forsikring') > 0) {
            $forsikringstekst = ' og afbestillingsforsikring';
        }


        $form = new HTML_QuickForm('onlinebetaling', 'POST', $this->url());

        if ($tilmelding->get('skyldig_depositum') > 0 AND $tilmelding->get('dato_forfalden') > date('Y-m-d')) {
            $form->addElement('header', null, 'Hvilket beløb vil du betale?');
            $options[] = &HTML_QuickForm::createElement('radio', null, null, $tilmelding->get('pris_total') . ' kroner (DKK) - dækker hele kursusprisen', $tilmelding->get('pris_total') * 100);
            $options[] = &HTML_QuickForm::createElement('radio', null, null, $tilmelding->get('pris_forudbetaling') . ' kroner (DKK) - dækker depositum' . $forsikringstekst, $tilmelding->get('pris_forudbetaling') * 100);

            $form->addGroup($options, 'amount', 'Beløb', '<br />');
            $form->addGroupRule('amount', 'Du skal vælge et beløb', 'required', null);

        } else {
            $form->addElement('header', null, 'Du skal betale nedenstående beløb');
            $form->addElement('radio', 'amount', 'Beløb', $tilmelding->get('skyldig') . ' kroner (DKK) - dækker resten af beløbet', $tilmelding->get('skyldig') * 100);
            $form->addRule('amount', 'Du skal vælge et beløb', 'required');
            $form->addRule('amount', 'Du skal vælge et beløb', 'numeric');
            $form->setDefaults(array('amount'=>$tilmelding->get('skyldig') * 100));
        }

        $form->addElement('header', null, 'Betaling');
        $form->addElement('text', 'cardnumber', 'Kortnummer');
        $form->addElement('text', 'cvd', 'Sikkerhedsnummer');
        $form->addElement('text', 'mm', 'Mdr.');
        $form->addElement('text', 'yy', 'År');
        $form->addElement('html', null, 'Vær opmærksom på, at det kan tage helt op til et minut at gennemføre transaktionen hos PBS.');
        $form->addElement('submit', null, 'Betal');

        $form->addRule('cardnumber', 'Du skal skrive et kortnummer', 'required');
        $form->addRule('cardnumber', 'Du skal skrive et kortnummer', 'numeric');
        $form->addRule('cvd', 'Du skal skrive et sikkerhedsnummer', 'required');
        $form->addRule('cvd', 'Du skal skrive et sikkerhedsnummer', 'numeric');
        $form->addRule('mm', 'Du skal udfylde Mdr.', 'required');
        $form->addRule('mm', 'Du skal udfylde Mdr.', 'numeric');
        $form->addRule('yy', 'Du skal udfylde År ', 'required');
        $form->addRule('yy', 'Du skal udfylde År', 'numeric');
        $form->applyFilter('__ALL__', 'trim');
        $form->applyFilter('__ALL__', 'addslashes');
        $form->applyFilter('__ALL__', 'strip_tags');

        return ($this->form = $form);
    }

    function execute()
    {
        $protocol = substr($this->url(), 0, 5);
        if ($protocol != 'https') {
            $link = 'https' . substr($this->url(), 4);
            throw new k_http_Redirect($link);
        }
        return parent::execute();
    }

}

<?php
/**
 * Onlinepayment for short courses
 *
 * @see /betaling/Betaling.php
 */
class VIH_Controller_KortKursus_Login_OnlineBetaling extends k_Component
{
    protected $form;
    protected $extra_text;
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $tilmelding = VIH_Model_KortKursus_Tilmelding::factory($this->context->name());
        $tilmelding->loadBetaling();

        // @todo add method to Tilmelding.php to make it easy to get missing payments
        if (count($tilmelding->betaling->getList('not_approved')) > 0) {
            $this->extra_text = '<p id="notice"><strong>Advarsel</strong>: Vær opmærksom på, at du har afventende betalinger på '.$tilmelding->get('betalt_not_approved').' kroner. Du skal altså kun bruge formularen, hvis du er helt sikker på, at du skal betale beløbene nedenunder.</p>';
        }

        $error = "";

        $this->document->setTitle('Betaling med dankort');

        $data = array(
            'tilmelding' => $tilmelding,
            'course_type' => 'korte',
            'extra_text' => $this->extra_text
        );

        $tpl = $this->template->create('Kundelogin/onlinebetaling');
        return $tpl->render($this, $data);
    }

    /**
     * NOTICE: First we need to make a local payment, so we have a
     * local id to use for capture at quickpay.
     * When the payment has been captured we set status = 000
     */
    function postForm()
    {
        $tilmelding = VIH_Model_KortKursus_Tilmelding::factory($this->context->name());
        if ($this->getForm()->validate()) {
            $eval = false;

            $betaling = new VIH_Model_Betaling("kortekurser", $tilmelding->get("id"));

            $betaling_amount = $this->body('amount')/100;
            $betaling_id = $betaling->save(array('type' => 'quickpay', 'amount' => $betaling_amount));
            if ($betaling_id == 0) {
                throw new Exception("Kunne ikke oprette betaling");
            }

            $onlinebetaling = new VIH_Onlinebetaling('authorize');
            $onlinebetaling->addCustomVar("Kursusnavn", "Kortkursus: ".$tilmelding->kursus->getKursusNavn());
            $onlinebetaling->addCustomVar("Kontaktnavn", $tilmelding->get("navn"));
            $onlinebetaling->addCustomVar("Tilmelding_ID", $tilmelding->get("id"));
            $eval = $onlinebetaling->authorize(
                $this->body('cardnumber'), // kortnummer
                $this->body('yy') . $this->body('mm'), //YYMM
                $this->body('cvd'), // sikkerhedsnummer
                $betaling_id, // ordrenummer
                $this->body('amount')    // beløb
            );

            if ($eval) {
                if ($eval['qpstat'] === '000') {
                    // The authorization was completed
                    $betaling->setTransactionnumber($eval['transaction']);
                    $betaling->setStatus('completed');

                    $historik = new VIH_Model_Historik($betaling->get('belong_to'), $betaling->get('belong_to_id'));
                    if (!$historik->save(array('betaling_id' => $betaling->get('id'), 'type' => 'dankort', 'comment' => 'Onlinebetaling # ' . $betaling->get('transactionnumber')))) {
                        throw new Exception('Der var en fejl med at gemme historikken.');
                    }

                    return new k_SeeOther($this->context->url());
                } else {
                    // An error occured with the authorize
                    $this->extra_text = '<p class="warning">Der opstod en fejl under transaktionen. '.$onlinebetaling->statuskoder[$eval['qpstat']].'. Du kan prøve igen.</p>';
                }
            } else {
                $this->extra_text = 'Kommunikationsfejl med PBS eller QuickPay';
            }
        }
        return $this->render();
    }

    function getForm()
    {
        if ($this->form) {
            return $this->form;
        }
        $tilmelding = VIH_Model_KortKursus_Tilmelding::factory($this->context->name());
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
        $form->addElement('text', 'yy', 'år');
        $form->addElement('html', null, 'Vær opmærksom på, at det kan tage helt op til et minut at gennemføre transaktionen hos PBS.');
        $form->addElement('submit', null, 'Betal');

        $form->addRule('cardnumber', 'Du skal skrive et kortnummer', 'required');
        $form->addRule('cardnumber', 'Du skal skrive et kortnummer', 'numeric');
        $form->addRule('cvd', 'Du skal skrive et sikkerhedsnummer', 'required');
        $form->addRule('cvd', 'Du skal skrive et sikkerhedsnummer', 'numeric');
        $form->addRule('mm', 'Du skal udfylde Mdr.', 'required');
        $form->addRule('mm', 'Du skal udfylde Mdr.', 'numeric');
        $form->addRule('yy', 'Du skal udfylde år ', 'required');
        $form->addRule('yy', 'Du skal udfylde år', 'numeric');
        $form->applyFilter('__ALL__', 'trim');
        $form->applyFilter('__ALL__', 'addslashes');
        $form->applyFilter('__ALL__', 'strip_tags');

        return ($this->form = $form);
    }

    function dispatch()
    {
        $url = $this->self_url();
        $protocol = substr($url, 0, 5);
        if ($protocol != 'https') {
            $link = 'https' . substr($url, 4);
            return new k_SeeOther($link);
        }
        return parent::dispatch();
    }

    function self_url()
    {
        if (!isset($_SERVER['REQUEST_URI'])) {
            $serverrequri = $_SERVER['PHP_SELF'];
        } else {
            $serverrequri = $_SERVER['REQUEST_URI'];
        }
        $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
        $protocol = $this->strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
        return $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri;
    }

    function strleft($s1, $s2)
    {
        return substr($s1, 0, strpos($s1, $s2));
    }
}

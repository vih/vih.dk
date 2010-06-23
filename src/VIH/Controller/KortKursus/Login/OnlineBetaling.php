<?php
/**
 * Dankortbetaling
 *
 * Her kan man betale med Dankort for et kort kursus.
 *
 * @see /betaling/Betaling.php
 */
class VIH_Controller_KortKursus_Login_OnlineBetaling extends k_Component
{
    private $form;
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

        // der skal lige laves noget i Tilmelding.php, sï¿½ vi har styr over hvor meget der mangler at blive betalt med de afventendede betalinger
        if (count($tilmelding->betaling->getList('not_approved')) > 0) {
            $this->extra_text = '<p id="notice"><strong>Advarsel</strong>: Vï¿½r opmï¿½rksom pï¿½, at du har afventende betalinger pï¿½ '.$tilmelding->get('betalt_not_approved').' kroner. Du skal altsï¿½ kun bruge formularen, hvis du er helt sikker pï¿½, at du skal betale belï¿½bene nedenunder.</p>';
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

    function postForm()
    {
        $tilmelding = VIH_Model_KortKursus_Tilmelding::factory($this->context->name());
        if ($this->getForm()->validate()) {
            // fï¿½rst skal vi oprette en betaling - som kan fungere som id hos qp
            // betalingen skal kobles til den aktuelle tilmelding
            // nï¿½r vi sï¿½ har haft den omkring pbs skal betalingen opdateres med status for betalingen
            // status sï¿½ttes til 000, hvis den er godkendt hos pbs.

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
                $this->body('amount')    // belï¿½b
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
                        throw new Exception('Der var en fejl med at gemme historikken.');
                    }

                    return new k_SeeOther($this->context->url());
                } else {
                    // An error occured with the authorize

                    $this->extra_text = '<p class="warning">Der opstod en fejl under transaktionen. '.$onlinebetaling->statuskoder[$eval['qpstat']].'. Du kan prï¿½ve igen.</p>';
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
            $form->addElement('header', null, 'Hvilket belï¿½b vil du betale?');
            $options[] = &HTML_QuickForm::createElement('radio', null, null, $tilmelding->get('pris_total') . ' kroner (DKK) - dï¿½kker hele kursusprisen', $tilmelding->get('pris_total') * 100);
            $options[] = &HTML_QuickForm::createElement('radio', null, null, $tilmelding->get('pris_forudbetaling') . ' kroner (DKK) - dï¿½kker depositum' . $forsikringstekst, $tilmelding->get('pris_forudbetaling') * 100);

            $form->addGroup($options, 'amount', 'Belï¿½b', '<br />');
            $form->addGroupRule('amount', 'Du skal vï¿½lge et belï¿½b', 'required', null);

        } else {
            $form->addElement('header', null, 'Du skal betale nedenstï¿½ende belï¿½b');
            $form->addElement('radio', 'amount', 'Belï¿½b', $tilmelding->get('skyldig') . ' kroner (DKK) - dï¿½kker resten af belï¿½bet', $tilmelding->get('skyldig') * 100);
            $form->addRule('amount', 'Du skal vï¿½lge et belï¿½b', 'required');
            $form->addRule('amount', 'Du skal vï¿½lge et belï¿½b', 'numeric');
            $form->setDefaults(array('amount'=>$tilmelding->get('skyldig') * 100));
        }

        $form->addElement('header', null, 'Betaling');
        $form->addElement('text', 'cardnumber', 'Kortnummer');
        $form->addElement('text', 'cvd', 'Sikkerhedsnummer');
        $form->addElement('text', 'mm', 'Mdr.');
        $form->addElement('text', 'yy', 'ï¿½r');
        $form->addElement('html', null, 'Vï¿½r opmï¿½rksom pï¿½, at det kan tage helt op til et minut at gennemfï¿½re transaktionen hos PBS.');
        $form->addElement('submit', null, 'Betal');

        $form->addRule('cardnumber', 'Du skal skrive et kortnummer', 'required');
        $form->addRule('cardnumber', 'Du skal skrive et kortnummer', 'numeric');
        $form->addRule('cvd', 'Du skal skrive et sikkerhedsnummer', 'required');
        $form->addRule('cvd', 'Du skal skrive et sikkerhedsnummer', 'numeric');
        $form->addRule('mm', 'Du skal udfylde Mdr.', 'required');
        $form->addRule('mm', 'Du skal udfylde Mdr.', 'numeric');
        $form->addRule('yy', 'Du skal udfylde ï¿½r ', 'required');
        $form->addRule('yy', 'Du skal udfylde ï¿½r', 'numeric');
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
            return new k_SeeOther($link);
        }
        return parent::execute();
    }

}

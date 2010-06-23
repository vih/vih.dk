<?php
/**
 * Dankortbetaling
 *
 * Her kan man betale med Dankort for et kort kursus.
 *
 * @see /betaling/Betaling.php
 *
 * @todo make sure that not every rate is displayed. Only the ones which has not been paid
 */
class VIH_Controller_LangtKursus_Login_OnlineBetaling extends k_Component
{
    private $form;
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $tilmelding = VIH_Model_LangtKursus_Tilmelding::factory($this->context->name());
        $tilmelding->loadBetaling();

        $extra_text = '';
        if (is_object($tilmelding->betalingsobject) AND count($tilmelding->betalingsobject->getList('not_approved')) > 0) {
            $extra_text = '<p id="notice"><strong>Advarsel</strong>: Vï¿½r opmï¿½rksom pï¿½, at du har afventende betalinger pï¿½ '.$tilmelding->get('betalt_not_approved').' kroner. Du skal kun bruge formularen, hvis du er helt sikker pï¿½, at du skal betale belï¿½bene nedenunder.</p>';
        }

        $error = "";

        $this->document->setTitle('Betaling med dankort');

        $data = array(
            'tilmelding' => $tilmelding,
            'course_type' => 'lange',
            'extra_text' => $extra_text
        );

        $tpl = $this->template->create('Kundelogin/onlinebetaling');
        return $tpl->render($this, $data);
    }

    function postForm()
    {
        $tilmelding = VIH_Model_LangtKursus_Tilmelding::factory($this->context->name());
        $tilmelding->loadBetaling();

        if ($this->getForm()->validate()) {
            // fï¿½rst skal vi oprette en betaling - som kan fungere som id hos qp
            // betalingen skal kobles til den aktuelle tilmelding
            // nï¿½r vi sï¿½ har haft den omkring pbs skal betalingen opdateres med status for betalingen
            // status sï¿½ttes til 000, hvis den er godkendt hos pbs.

            $eval = false;

            $betaling = $tilmelding->betalingFactory();

            $submitted_amount = $this->body('amount');
            if (is_array($submitted_amount)) {
                $amount = 0;
                foreach ($submitted_amount as $amount) {
                    $total_amount += $amount;
                }
            } elseif (is_numeric($submitted_amount)) {
                $total_amount = $submitted_amount;
            } else {
                throw new Exception('De postede belï¿½bsvï¿½rdier er ikke gyldige');
            }

            $betaling_amount = $total_amount / 100;
            $betaling_id = $betaling->save(array('type' => 'quickpay', 'amount' => $betaling_amount));
            if($betaling_id == 0) {
                throw new Exception("Kunne ikke oprette betaling");
            }

            $onlinebetaling = new VIH_Onlinebetaling('authorize');

            $onlinebetaling->addCustomVar("Kursusnavn", "Langtkursus: ".$tilmelding->kursus->get("kursusnavn"));
            $onlinebetaling->addCustomVar("Navn", $tilmelding->get("navn"));
            $onlinebetaling->addCustomVar("Tilmelding_ID", $tilmelding->get("id"));

            $eval = $onlinebetaling->authorize(
                $this->body('cardnumber'), // kortnummer
                $this->body('yy') . $this->body('mm'), //YYMM
                $this->body('cvd'), // sikkerhedsnummer
                $betaling_id, // ordrenummer
                $total_amount   // belï¿½b
            );

            if ($eval) {
                if ($eval['qpstat'] === '000') {
                    // The authorization was completed

                    /*
                    echo 'Authorization: ' . $qpstatText["" . $eval['qpstat'] . ""] . '<br />';
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
                    $error = "<p><strong>Der opstod en fejl under transaktionen. ".$onlinebetaling->statuskoder[$eval['qpstat']].". Du kan prï¿½ve igen.</strong></p>";
                    /*
                    echo 'Authorization: ' . $qpstatText["" . $eval['qpstat'] . ""] . '<br />';
                    echo "<pre>";
                    var_dump($eval);
                    echo "</pre>";
                    */
                }
            } else {
                throw new Exception('Kommunikationsfejl med PBS og QuickPay');
            }
        }
        return $this->render();
    }

    public function getForm()
    {
        if ($this->form) {
            return $this->form;
        }

        $tilmelding = VIH_Model_LangtKursus_Tilmelding::factory($this->context->name());
        $tilmelding->loadBetaling();

        $form = new HTML_QuickForm('onlinebetaling', 'POST', $this->url());
        $form->addElement('header', null, 'Hvilke belï¿½b vil du betale?');

        if ($tilmelding->get('skyldig_tilmeldingsgebyr') > 0) {
            $options[0] = HTML_QuickForm::createElement('checkbox', 0, null, number_format($tilmelding->get('skyldig_tilmeldingsgebyr'), 0, ',','.') . ' kroner (DKK) - dï¿½kker tilmeldingsgebyret');
            $options[0]->updateAttributes(array('value'=>$tilmelding->get('skyldig_tilmeldingsgebyr') * 100));
        }

        $i = 1;

        if ($tilmelding->antalRater() > 0) {
            foreach ($tilmelding->getRater() AS $rate) {

                $options[$i] = HTML_QuickForm::createElement('checkbox', $i, null, number_format($rate['beloeb'], 0, ',','.') . ' kroner (DKK) - forfalder ' . $rate['dk_betalingsdato']);
                $options[$i]->updateAttributes(array('value'=>$rate['beloeb'] * 100));
                $i++;
            }
        } elseif ($tilmelding->get('skyldig_tilmeldingsgebyr') == 0) {
                $options[0] = HTML_QuickForm::createElement('checkbox', $i, null, 'Du kan betale igen, nï¿½r vi har oprettet dine rater.');
                $options[0]->updateAttributes(array('disabled'=>'disabled'));
        }

        $form->addGroup($options, 'amount', 'Belï¿½b', '<br />');

        $form->addElement('header', null, 'Betaling');
        $form->addElement('text', 'cardnumber', 'Kortnummer');
        $form->addElement('text', 'cvd', 'Sikkerhedsnummer');
        $form->addElement('text', 'mm', 'Mdr.');
        $form->addElement('text', 'yy', 'ï¿½r');
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
            throw new k_SeeOther($link);
        }
        return parent::execute();
    }
}

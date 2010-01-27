<?php
/**
 * Dankortbetaling
 *
 * Her kan man betale med Dankort for elevforeningen.
 *
 * @see /betaling/Betaling.php
 *
 * Skal knyttes til betaling for et enkelt elevstï¿½vne.
 */


require 'include_elevforeningen_login.php';
require_once 'DB/Sql.php';
require_once 'VIH/Model/Betaling.php';
require_once 'VIH/Onlinebetaling.php';
require_once 'Validate.php';
require_once 'VIH/Model/Historik.php';

$extra_text = '';

$contact = $auth->getContact($_SESSION['contact_id']);

$betaling_amount = $_SESSION['amount'];
$order_id = $_SESSION['order_id'];

$client = new IntrafacePublic_Shop_XMLRPC_Client($credentials, false);

$error = "";

$form = new HTML_QuickForm;

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



$form->applyFilter('trim', '__ALL__');
$form->applyFilter('addslashes', '__ALL__');
$form->applyFilter('strip_tags', '__ALL__');

if ($form->validate()) {

    # fï¿½rst skal vi oprette en betaling - som kan fungere som id hos qp
    # betalingen skal kobles til den aktuelle tilmelding

    # nï¿½r vi sï¿½ har haft den omkring pbs skal betalingen opdateres med status for betalingen
    # status sï¿½ttes til 000, hvis den er godkendt hos pbs.

    $eval = false;

    $betaling = new VIH_Model_Betaling('elevforeningen', $order_id);

    $betaling_amount_quickpay =  $betaling_amount * 100;
    $betaling_id = $betaling->save(array('type' => 'quickpay', 'amount' => $betaling_amount));
    if($betaling_id == 0) {
        trigger_error("Kunne ikke oprette betaling", E_USER_ERROR);
    }

    $onlinebetaling = new VIH_Onlinebetaling('authorize');

    $onlinebetaling->addCustomVar('Elevforeningsmedlem', $contact['number']);
    $onlinebetaling->addCustomVar('Kontaktid', $contact['id']);


    $eval = $onlinebetaling->authorize(
        $form->exportValue('cardnumber'), // kortnummer
        $form->exportValue('yy') . $form->exportValue('mm'), //YYMM
        $form->exportValue('cvd'), // sikkerhedsnummer
        $betaling_id, // ordrenummer
        $betaling_amount_quickpay	// belï¿½b
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
            if (!$historik->save(array('type' => 'dankort', 'comment' => 'Onlinebetaling # ' . $betaling->get('transactionnumber')))) {
                trigger_error('Der var en fejl med at gemme historikken.', E_USER_ERROR);
            }

            $data = array(
                'belong_to' => 'order', // 1 is order, 2 is invoice
                'belong_to_id' => $order_id,
                'transaction_number' => $eval['transaction'],
                'transaction_status' => $eval['qpstat'],
		'pbs_status' => $eval['pbsstat'],
                'amount' => $betaling_amount
            );

            $client->saveOnlinePayment($data);
            //$client->addOnlinePayment($order_id, $eval['transaction'], $eval['qpstat'], $betaling_amount);

            header("Location: index.php");
            exit;

        }
        else {
            // An error occured with the authorize

            $error = '<p class="warning">Der opstod en fejl under transaktionen. '.$onlinebetaling->statuskoder[$eval['qpstat']].'. Du kan prøve igen.</p>';
            /* 
            echo 'Authorization: ' . $qpstatText["" . $eval['qpstat'] . ""] . '<br />';
            echo "<pre>";
            var_dump($eval);
            echo "</pre>";
            */
        }
    }
    else {
        trigger_error('Kommunikationsfejl med PBS eller QuickPay', E_USER_ERROR);
    }
}

$tpl = new Template(PATH_TEMPLATE_KUNDELOGIN);
$tpl->set('title', 'Betaling med dankort');
$tpl->set('body_class', 'sidebar');
$tpl->set('content_main', '
    <div id="content-main">
    <h1>Betaling</h1>
    <p>Tak fordi du bruger <span class="dankort">Dankort</span> til at betale for din tilmelding.</p>
    <p><strong>Du skal betale '.number_format($betaling_amount, 0, ',', '.').' kroner.</strong></p>
    '.$extra_text.'
    ' .$error. $form->toHTML() .
    '</div>
    <div id="content-sub">
    <h2>Sikkerhedsnummeret</h2>
    <p>Du finder sikkerhedsnummeret (cvd) bag på Dankortet.</p>
    <p><img src="/gfx/images/dankort_cifre.gif" alt="Hvor er sikkerhedscifrene" /></p>

    <h2>Sikkerhed</h2>
    <p>Du kan læse mere om sikkerhed og <span class="dankort">Dankort</span> på <a href="http://www.betaling.dk/" title="Linket åbner i et nyt vindue" target="_blank">PBS</a>.</p>
    <p>Vores betalingsløsning ligger på en sikker server, og vi gemmer aldrig kortoplysninger i vores database.</p>
    <p>Hvis du har spørgsmål, er du velkommen til at ringe til os på telefon 7582 0811.</p>

    </div>
');

echo $tpl->fetch('main-tpl.php');


?>

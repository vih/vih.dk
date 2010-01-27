<?php
/**
 * Dekorator til Quickpay klassen.
 *
 * Skrevet så vi undgår at skulle sætte en masse af de faste variable på de
 * enkelte sider. Skal returnere et array i pay.
 *
 * @author Lars Olesen <lars@legestue.net>
 */

require_once 'Payment/Quickpay.php';

class VIH_Onlinebetaling
{
    var $statuskoder = array(
        '' => 'Ingen kontakt til Quickpay - mangler $eval',
        '000' => 'Godkendt',
        '001' => 'Afvist af PBS',
        '002' => 'Kommunikationsfejl',
        '003' => 'Kort udløbet',
        '004' => 'Status er forkert (Ikke autoriseret)',
        '005' => 'Autorisation er forældet',
        '006' => 'Fejl hos PBS',
        '007' => 'Fejl hos QuickPay',
        '008' => 'Fejl i parameter sendt til QuickPay'
    );
    var $msg_types = array(
        '1100' => 'authorize', // tjekker
        '1220' => 'capture', // hæver
        'credit' => 'credit', // tilbagebetaler
        '1420' => 'reversal', // ophæver reservationen
        'status' => 'status' // ophæver reservationen

    );
    var $type = 'quickpay';
    var $eval;
    var $quickpay;
    var $msgtype; // jf. http://www.quickpay.dk/vejledning/integration/beskedtyper.php
    var $md5checkword;
    var $merchant;
    var $posc; // type transaktion, jf. http://www.quickpay.dk/vejledning/integration/posctyper.php

    function __construct($msg_type = 'authorize', $posc = 'K00500K00130')
    {
        if (!array_search($msg_type, $this->msg_types)) {
            throw new Exception('Ikke en gyldig msg_type i OnlineBetaling');
        }
        $this->quickpay = new quickpay;
        $this->quickpay->set_msgtype(array_search($msg_type, $this->msg_types));
        $this->quickpay->set_md5checkword(QUICKPAY_MD5_SECRET);
        $this->quickpay->set_merchant(QUICKPAY_MERCHANT_ID);
        $this->quickpay->set_posc($posc);
        $this->quickpay->set_curl_certificate(PATH_ROOT . 'certifikater/cacert.pem');
    }

    function addCustomVar($var, $value)
    {
        $this->quickpay->add_customVars($var, $value);
    }

    function authorize($cardnumber, $expirationdate, $cvd, $ordernum, $amount)
    {
        $this->quickpay->set_cardnumber($cardnumber);
        $this->quickpay->set_expirationdate($expirationdate); // YYMM
        $this->quickpay->set_cvd($cvd);
        $this->quickpay->set_ordernum($ordernum); // MUST at least be of length 4
        $this->quickpay->set_amount($amount); // skal være i ører
        $this->quickpay->set_currency('DKK');

        $this->eval = $this->quickpay->authorize();

        $this->save();

        return $this->eval;
    }

    function capture($transaction, $amount)
    {

        $this->quickpay->set_transaction($transaction);
        $this->quickpay->set_amount($amount);
        // Commit the capture
        $this->eval = $this->quickpay->capture();

        return $this->eval;
    }

    function reverse($transaction)
    {
        $this->quickpay->set_transaction($transaction);
        $this->eval = $this->quickpay->reverse();
        return $this->eval;
    }

    function save()
    {
        $db = new DB_Sql;
        $db->query("INSERT INTO betaling_online SET date_created = NOW(), type='".$this->type."', transaktionsnummer = '', status='".$this->eval['qpstat']."'");
        return 1;
    }

}
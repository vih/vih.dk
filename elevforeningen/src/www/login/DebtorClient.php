<?php
/**
 * NewsletterClient
 *
 * Husk at redigere indstillingerne i klassen til at pege på din egen adgang
 * til nyhedsbrevet.
 *
 * @author Lars Olesen <lars@legestue.net>
 * @version 1.0
 *
 * Include the Incution XML RPC library
 * http://scripts.incutio.com/xmlrpc/
 */

require_once('IXR/IXR.php');

class DebtorClient {
	/**
	 * Instance of IXR_Client class
	 * @access private
	 * @var IXR_Client
	 */
	var $client;

	/**
	 * Credentials til at hente oplysninger fra serveren
	 * @access private
	 * @var array
	 */
   var $credentials;


	/**
	 * Newsletter constructor
	 * @param boolean true switches on debugging
	 * @access public
	 */
	function DebtorClient($credentials, $debug = false) {

		/***************************************************************************
		 * Settings. Skal ændres inden klassen tages i brug
		 **************************************************************************/

		// url til serveren
		$url = 'http://www.intraface.dk/xmlrpc/debtor/DebtorServer.php';

		// credentials
		$this->credentials = $credentials;
		$this->credentials['session_id'] = md5(session_id());

		// starter de nødvendige ting op
		$this->client= new IXR_Client($url);
		$this->client->debug=$debug;
	}

	/**
	 * Metode til at tilmelde sig nyhedsbrevet
	 * @param $search (string)
	 * @return array
	 * @access public
	 */
	function get($id) {

		if (!$this->client->query('debtor.get', $this->credentials, $id)) {
			trigger_error($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}
		return $this->client->getResponse();
	}

	function getList($type, $contact_id) {
		if (!$this->client->query('debtor.list', $this->credentials, $type, $contact_id)) {
			trigger_error($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}
		return $this->client->getResponse();
	}

	function pdf($id) {
		if (!$this->client->query('debtor.pdf', $this->credentials, $id)) {
			print($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}

		return $this->client->getResponse();
	}

	function setSent($id) {
		if (!$this->client->query('debtor.setSent', $this->credentials, $id)) {
			print($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}

		return $this->client->getResponse();

	}

	function createInvoice($id) {
		if (!$this->client->query('debtor.createInvoice', $this->credentials, $id)) {
			print($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}

		return $this->client->getResponse();

	}

	function capturePayment($transactionnumber) {
		if (!$this->client->query('payment.capture', $this->credentials, $transactionnumber)) {
			print($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}

		return $this->client->getResponse();

	}
}

?>
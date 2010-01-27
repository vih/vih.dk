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

class ContactClient {
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
	function ContactClient($credentials, $debug = false) {

		/***************************************************************************
		 * Settings. Skal ændres inden klassen tages i brug
		 **************************************************************************/

		// url til serveren
		$url = 'http://www.intraface.dk/xmlrpc/contact/ContactServer.php';

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
		if (!$this->client->query('contact.get', $this->credentials, $id)) {
			trigger_error($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}
		return $this->client->getResponse();
	}

	function factory($type, $value) {
		if (!$this->client->query('contact.factory', $this->credentials, $type, $value)) {
			trigger_error($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}
		return $this->client->getResponse();
	}

	function save($var) {
		if (!$this->client->query('contact.save', $this->credentials, $var)) {
			trigger_error($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}
		return 1;

	}

	function sendLoginEmail($id) {
		if (!$this->client->query('contact.sendLoginEmail', $this->credentials, $id)) {
			trigger_error($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}
		return 1;
	}

	function getKeywords() {
		if (!$this->client->query('contact.getKeywords', $this->credentials)) {
			trigger_error($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}
		return $this->client->getResponse();

	}

	function getConnectedKeywords($id) {
		if (!$this->client->query('contact.getConnectedKeywords', $this->credentials, $id)) {
			trigger_error($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}
		return $this->client->getResponse();

	}


}

?>
<?php
/**
 * Klasse til at lave login til kontaktlogin
 *
 * @author Lars Olesen <lars@legestue.net>
 */

require_once('Session/Session.php');

class Auth {

	var $session;
	var $private_key;
	var $contact;
	var $contact_id;
	var $contact_client;

	function Auth() {
		$arg = func_get_args();
		$this->private_key = $arg[0];

		$this->session = &new Session();
		$this->session->set('session_id', session_id());

		$this->contact_client = new ContactClient(array('private_key' => $this->private_key), false);

		if (!empty($arg[1]) AND is_string($arg[1])) {
			$this->login($arg[1]);
		}
		elseif ($contact_id = $this->session->get('contact_id')) {
			$this->contact = $this->contact_client->get($contact_id);
		}
		else {
			header('Location: login.php');
			exit;
		}

	}

	function login($password) {
		$this->session->set('contact_id', 0);
		$this->contact = $this->contact_client->factory('code', $password);
		if (empty($this->contact)) {
			return 0;
		}
		$this->session->set('contact_id', $this->contact['id']);
		$this->auth($this->private_key);
	}

	function isLoggedIn() {
		if ($this->session->get('contact_id')) {
			return 1;
		}
		return 0;
	}

	function get() {
		return $this->contact;
	}

	/**
	 * @todo Denne funktion giver en fejlmeddelelse
	 *
	 */
	function logout() {
		$this->session->destroy();
		$this->auth($this->private_key);
	}

}

?>
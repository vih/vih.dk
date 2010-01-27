<?php

/**
 * WebshopClient
 *
 * Husk at redigere indstillingerne i klassen til at pege på din egen adgang
 * til webshoppen. Start altid webshopclient op som det første på hver side.
 *
 * @author Lars Olesen <lars@legestue.net>
 * @version 1.0
 *
 * Include the Incution XML RPC library
 * http://scripts.incutio.com/xmlrpc/
 */

 require_once('IXR/IXR.php');

class WebshopClient {
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
	 * Webshopclient constructor
	 * @param boolean true switches on debugging
	 * @access public
	 */
	function WebshopClient($debug = false) {

		session_start();

		/***************************************************************************
		 * Settings. Skal ændres inden klassen tages i brug
		 **************************************************************************/

		// url til serveren
		$url = 'http://www.intraface.dk/xmlrpc/webshop/WebshopServer.php';

		// credentials
		$this->credentials = array(
			"private_key" => 'L9FtAdfAu8QwLSChGZehzeZwiAhXNwsqwWIMZF4avCw6jY6HN2G',
			"session_id" => md5(session_id())
		);

		// starter de nødvendige ting op
		$this->client= new IXR_Client($url);
		$this->client->debug=$debug;
	}

	/***************************************************************************
	 * Metoder til produkter
	 **************************************************************************/

	/**
	 * Returns an array of articles
	 * @param $search (string)
	 * @return array
	 * @access public
	 */
	function getProducts($search = '') {
		if (!$this->client->query('products.getList', $this->credentials, $search)) {
			trigger_error($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}
		return $this->client->getResponse();
	}

	function getProductsPaging() {
		if (!$this->client->query('products.getPaging', $this->credentials)) {
			trigger_error($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}
		return $this->client->getResponse();
	}

	function getProduct($id) {
		if (!$this->client->query('products.getProduct', $this->credentials, $id)) {
			trigger_error($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}
		return $this->client->getResponse();
	}

	function getRelatedProducts($id) {
		if (!$this->client->query('products.getRelatedProducts', $this->credentials, $id)) {
			trigger_error($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}
		return $this->client->getResponse();
	}

	function getProductsByKeywords ($keyword_id) {
		if (!$this->client->query('products.getProductsByKeywords', $this->credentials, $keyword_id)) {
			trigger_error($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
			return false;
		}
		return $this->client->getResponse();
	}

  /***************************************************************************
   * Metoder til selve indkøbskurven
   **************************************************************************/

  function addBasket($product_id) {
		if (!$this->client->query('basket.add', $this->credentials, $product_id)) {
  		trigger_error($this->client->getErrorCode(). ' : '.$this->client->getErrorMessage());
    }
    return true;
	}

  function changeBasket($product_id, $quantity) {
		if (!$this->client->query('basket.change', $this->credentials, $product_id, $quantity)) {
	  	trigger_error('An error occurred - '.$client->getErrorCode().":".$client->getErrorMessage());
		}
  	return true;
  }

  function getBasketPrice() {
		if (!$this->client->query('basket.totalPrice', $this->credentials)) {
  		trigger_error($this->client->getErrorCode(). ' : ' .$this->client->getErrorMessage());
    }
		return $this->client->getResponse();
  }

  function getItems() {
		if (!$this->client->query('basket.getItems', $this->credentials)) {
	  		trigger_error('An error occurred - '.$this->client->getErrorCode().":".$this->client->getErrorMessage());
		}
		return $this->client->getResponse();
  }

  function getBasketWeight() {
		if (!$this->client->query('basket.totalWeight', $this->credentials)) {
  		trigger_error($this->client->getErrorCode(). ' : ' .$this->client->getErrorMessage());
    }
		return $this->client->getResponse();
  }

  /***************************************************************************
   * Metoder til at placere ordren
   **************************************************************************/

	/**
   * Funktionen sender ordren til systemet
   *
   * @param $order (array)
   * $order['company'] = $_POST['navn'];
   * $order['contactname'] = $_POST['navn'];
	 * $order['address'] = $_POST['adresse'];
	 * $order['postalcode'] = $_POST['postnr'];
	 * $order['town'] = $_POST['bynavn'];
	 * $order['email'] = $_POST['email'];
	 * $order['phone'] = $_POST['telefonnummer'];
   * @access public
   */

	function placeOrder($order) {
		if (!$id =$this->client->query('basket.placeOrder', $this->credentials, $order)) {
			//if (!$client->query('products.test', $args)) {
			trigger_error('An error occurred - '.$this->client->getErrorCode().":".$this->client->getErrorMessage());
		}

		return $this->client->getResponse();
	}
	function addOnlinePayment($order_id, $transaction_number, $transaction_status, $amount) {
		if (!$this->client->query('payment.addOnlinePayment', $this->credentials, $order_id, $transaction_number, $transaction_status, $amount)) {
			//if (!$client->query('products.test', $args)) {
			trigger_error('An error occurred - '.$this->client->getErrorCode().":".$this->client->getErrorMessage());
		}
		return 1;
	}

}


?>
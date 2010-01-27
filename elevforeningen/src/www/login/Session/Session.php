<?php
/**
* @package SPLIB
* @version $Id: Session.php,v 1.6 2003/08/17 22:13:17 harry Exp $
*/
/**
* A wrapper around PHP's session functions
* <code>
* $session = new Session();
* $session->set('message','Hello World!');
* echo ( $session->get('message'); // Displays 'Hello World!'
* </code>
* @package SPLIB
* @access public
*/
class Session {
    /**
    * Session constructor<br />
    * Starts the session with session_start()
    * <b>Note:</b> that if the session has already started, session_start()
    * does nothing
    * @access public
    */
    function Session () {
	 	if (!$this->is_started()) {
			session_start();
		}

    }

	 function singleton() {
		static $instance;
		if ($instance == NULL) {
			return new Kernel;
		}
		return $instance;
	 }

	 function is_started() {
	    // save current id
    	$session_id = session_id();

		if(session_regenerate_id()) {
			// restore old id cause session_regenerate_id change it
			session_id($session_id);
			return true;
		}
		else{
			return false;
		}
	 }

    /**
    * Sets a session variable
    * @param string name of variable
    * @param mixed value of variable
    * @return void
    * @access public
    */
    function set ($name,$value) {
        $_SESSION[$name]=$value;
    }

    /**
    * Fetches a session variable
    * @param string name of variable
    * @return mixed value of session varaible
    * @access public
    */
    function get ($name) {
        if ( isset ( $_SESSION[$name] ) )
            return $_SESSION[$name];
        else
            return false;
    }

    /**
    * Deletes a session variable
    * @param string name of variable
    * @return boolean
    * @access public
    */
    function del ($name) {
        if ( isset ( $_SESSION[$name] ) ) {
            unset ( $_SESSION[$name] );
            return true;
        } else {
            return false;
        }
    }

    /**
    * Destroys the whole session
    * @return void
    * @access public
    */
    function destroy () {
        $_SESSION = array();
        session_destroy();
    }
}
?>
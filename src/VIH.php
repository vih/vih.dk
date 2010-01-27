<?php
/**
 * This is to be included on every page
 *
 * @package VIH
 * @author  Lars Olesen <lars@legestue.net>
 */

require_once 'VIH/functions.php';
require_once 'VIH/configuration.php';
require_once 'VIH/errorhandler.php';
require_once 'k.php';

set_error_handler('vih_error_handler');

if (!function_exists('email')) {
  /**
   * This function is dynamically redefinable.
   * @see $GLOBALS['_global_function_callback_email']
   */
  function email($args) {
    $args = func_get_args();
    return call_user_func_array($GLOBALS['_global_function_callback_email'], $args);
  }
  if (!isset($GLOBALS['_global_function_callback_email'])) {
    $GLOBALS['_global_function_callback_email'] = NULL;
  }
}

$GLOBALS['_global_function_callback_email'] = 'vih_email';

if (!function_exists('autoop')) {
  /**
   * This function is dynamically redefinable.
   * @see $GLOBALS['_global_function_callback_email']
   */
  function autoop($args) {
    $args = func_get_args();
    return call_user_func_array($GLOBALS['_global_function_callback_autoop'], $args);
  }
  if (!isset($GLOBALS['_global_function_callback_autoop'])) {
    $GLOBALS['_global_function_callback_autoop'] = NULL;
  }
}

$GLOBALS['_global_function_callback_autoop'] = 'vih_autoop';


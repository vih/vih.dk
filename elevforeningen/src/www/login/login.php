<?php
set_include_path('/home/vih/pear/php/' . PATH_SEPARATOR . get_include_path());

require_once 'include_elevforeningen.php';
require_once 'HTML/QuickForm.php';
//require_once 'Template/Template.php';
require_once 'IntrafacePublic/Contact/XMLRPC/Client.php';

session_start();

$credentials = array('private_key' => INTRAFACE_PRIVATE_KEY,
                     'session_id' => md5(session_id()));

$form = new HTML_QuickForm('login', 'get');
$form->addElement('text', 'handle', 'Kode');
$form->addElement('submit', null, 'Login');

$form->addRule('handle', 'Du skal indtaste en kode', 'required');

$form->applyFilter('__ALL__', 'trim');
$form->applyFilter('__ALL__', 'strip_tags');
$form->applyFilter('__ALL__', 'addslashes');

$form->setDefaults(array(
    'handle' => @$_GET['handle'] /* handle */
));

if ($form->validate()) {
    $auth = new IntrafacePublic_Contact_XMLRPC_Client($credentials);
    $contact_array = $auth->authenticateContact($form->exportValue('handle'));
    $_SESSION['contact_id'] = $contact_array['id'];

    if ($auth->isLoggedIn()) {
        header('Location: index.php');
        exit;
    }
}



$tpl = new Template(PATH_TEMPLATE_KUNDELOGIN);
$tpl->set('title', 'Login');
$tpl->set('content_main', '
    <h1>Login</h1>
    <p>Du kan logge ind ved at indtaste din kode.</p>
    ' . $form->toHTML());

echo $tpl->fetch('main-tpl.php');
?>

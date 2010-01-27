<?php
require 'include_kursuscenter.php';
require 'HTML/QuickForm.php';
require 'IntrafacePublic/Newsletter/XMLRPC/Client.php';

$title = 'Nyhedsbrev';
$meta = array(
    'keywords' => '',
    'description' => ''
);
$msg = '';

$form = new HTML_QuickForm;
$form->addElement('text', 'email', 'E-mail');
$radio[0] =& HTML_QuickForm::createElement('radio', null, null, 'tilmeld', '1');
$radio[1] =& HTML_QuickForm::createElement('radio', null, null, 'frameld', '2');
$form->addGroup($radio, 'mode', null, null);
$form->addElement('submit', null, 'Gem');
$form->setDefaults(array(
    'mode' => 1
));
$form->addRule('email', 'Du skal skrive en e-mail-adresse', 'required', null);

$credentials = array(
    'private_key' => 'Uzt6hhXRS9zrsu8JvdBmh1MdkwaaFSQgg15p8S5IJkYSFNiZIJb',
    'session_id' => md5(date('H:i:s d-Y/m'))
);

$list_id = 17;

if ($form->validate()) {
    $client = new IntrafacePublic_Newsletter_XMLRPC_Client($credentials);
    if ($form->exportValue('mode') == 1) {
        if ($client->subscribe($list_id, $form->exportValue('email'), $_SERVER['REMOTE_ADDR'])) {
            $msg = '<p class="notice">Du er tilmeldt nyhedsbrevet.</p>';
        }
        else {
            $msg = '<p class="alert">Du blev ikke tilmeldt. Måske har ud indtastet din e-mail forkert.</p>';
        }
    }
    elseif ($form->exportValue('mode') == 2) {
        if ($client->unsubscribe($list_id, $form->exportValue('email'))) {
            $msg = '<p classs="notice">Du er nu frameldt nyhedsbrevet.</p>';
        }
        else {
            $msg = '<p class="alert">Du blev ikke frameldt. Måske har ud indtastet din e-mail forkert.</p>';
        }
    }
}

$tpl = new VIH_Frontend_Kursuscenter();
$tpl->set('title', $title);
$tpl->set('meta', $meta);
$tpl->set('content_main', '
    <h1>Nyhedsbrev</h1>
    ' . $msg . '
    <p>Vi udsender seks-otte nyhedsbreve om året. Nyhedsbrevene fortæller om de vigtigste nyheder fra Vejle Idrætshøjskoles elevforening. Nyhedsbrevet sendes i tekstformat.</p>
' . $form->toHTML());

$tpl->display('main-tpl.php');

?>
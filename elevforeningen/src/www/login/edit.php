<?php
require 'include_elevforeningen_login.php';

$values = $auth->getContact($_SESSION['contact_id']);
$values = utf8_decoding($values);

$form = new HTML_QuickForm;
$form->addElement('hidden', 'id');
$form->addElement('text', 'name', 'Navn', array('size' => 40));
$form->addElement('text', 'address', 'Adresse',  array('size' => 40));
$form->addElement('text', 'postcode', 'Postnr.',  array('size' => 4));
$form->addElement('text', 'city', 'Postby',  array('size' => 40));
$form->addElement('text', 'email', 'E-mail',  array('size' => 40));
$form->addElement('text', 'phone', 'Telefon',  array('size' => 8));
$form->addElement('submit', NULL, 'Gem');

$form->setDefaults(array(
    'id' => $values['id'],
    'name' => $values['name'],
    'address' => $values['address'],
    'postcode' => $values['postcode'],
    'city' => $values['city'],
    'phone' => $values['phone'],
    'email' => $values['email']
));

if ($form->validate()) {
    if ($auth->saveContact($form->exportValues())) {
        header('Location: index.php');
        exit;
    }
    else {
        trigger_error('Kunne ikke gemme', E_USER_ERROR);
    }
}

$tpl = new Template(PATH_TEMPLATE_KUNDELOGIN);
$tpl->set('content_main', '
    <h1>Ret oplysninger</h1>
    <p><a href="index.php">Luk uden at gemme</a></p>
    ' . $form->toHTML());

echo $tpl->fetch('main-tpl.php');

?>
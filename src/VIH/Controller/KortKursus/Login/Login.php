<?php
/*
require('include_kundelogin.php');

if ($usr->isLoggedIn()) {
    header('Location: index.php');
    exit;
}
$form = new HTML_QuickForm('kundelogin', 'get');
$form->addElement('text', 'handle', 'Ordrekode');
$form->addElement('submit', null, 'Login');

$form->addRule('handle', 'Du skal indtaste en kode', 'required');

$form->applyFilter('__ALL__', 'trim');
$form->applyFilter('__ALL__', 'strip_tags');
$form->applyFilter('__ALL__', 'addslashes');

$form->setDefaults(array(
    'handle' => $usr->getProperty('handle')
));

if ($form->validate()) {
    $usr->login($form->exportValue('handle'), $form->exportValue('handle'));

    if ($usr->isLoggedIn()) {

        header('Location: index.php');
        exit;
    }
}

$tpl = new VIH_Frontend_Kundelogin();
$tpl->set('title', 'Login');
$tpl->set('content_main', $form->toHTML());


*/

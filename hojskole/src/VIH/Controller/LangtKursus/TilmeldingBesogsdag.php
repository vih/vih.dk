<?php
/*
require('../include_vih.php');
require('vih/email.php');
require('HTML/QuickForm.php');

$title = 'Tilmelding til h�jskoledag';
$meta['description'] = 'Her kan du tilmelde dig bes�gsdagen p� Vejle Idr�tsh�jskole.';
$meta['keywords'] = '';

$form = new HTML_QuickForm;
$form->addElement('text', 'navn', 'Navn');
$form->addElement('text', 'telefon', 'Telefon');
$form->addElement('text', 'email', 'E-mail');
$form->addElement('submit', NULL, 'Tilmeld');

$msg = '<p>Du kan tilmelde dig til vores bes�gsdag ved at udfylde formularen nedenunder. Hvis du har sp�rgsm�l til bes�gsdagen eller om tilmeldingen, er du meget velkommen til at <a href="/kontakt/">kontakte os</a>.</p>' . $form->toHTML();

if ($form->validate()) {
    if(defined('EMAIL_STATUS') && EMAIL_STATUS == 'online') {
        if (Validate::email($form->exportValue('email')) AND trim($form->exportValue('email')) != '') {

            $error = '';

            $body  = "TILMELDING TIL H�JSKOLEDAG\n";
            $body .= "Navn: " .$form->exportValue('navn') . "\n";
            $body .= "Telefon: ". $form->exportValue('telefon') . "\n";
            $body .= "E-mail: " .$form->exportValue('email') . "\n";

            $mailer = new VIH_Email;
            $mailer->setSubject('Tilmelding til h�jskoledag');
            $mailer->setFrom($form->exportValue('email'), $form->exportValue('navn'));
            $mailer->addAddress('jesper@vih.dk', 'Jesper Dupont');
            $mailer->setBody($body);

            if ($mailer->send()) {
                $msg  = '<p><strong>Tak for din tilmelding.</strong></p>';
                $msg .=	'<h3>Tilmeld dig vores nyhedsbrev</h3>';
                $msg .= '<p>Hvis du gerne vil holde dig orienteret om, hvad der sker p� Vejle Idr�tsh�jskole, kan du <a href="/nyhedsbrev/">tilmelde dig vores nyhedsbrev</a>.</p>';
            }
            else {
                $msg  = '<p style="color: red;"><strong>Tilmeldingen blev ikke sendt - <a href="'.$_SERVER['PHP_SELF'].'">pr�v igen</a> eller ring til 75820811.</strong></p>';
            }
        }
    }
}

$main = new Template(PATH_TEMPLATE);
$main->set('title', $title);
$main->set('meta', $meta);

$main->set('content_main', '
    <h1>Tilmelding til bes�gsdag</h1>
    '.$msg);


*/
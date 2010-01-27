<?php
//die('only run after setting up the date');
require_once 'config.local.php';
set_include_path(PATH_INCLUDE);
require_once 'Ilib/ClassLoader.php';

$date = date('Y-m-d');

$db = MDB2::factory(DB_DSN);
$res = $db->query('SELECT langtkursus_tilmelding.id
	FROM langtkursus_tilmelding
	INNER JOIN langtkursus ON langtkursus.id = langtkursus_tilmelding.kursus_id
	WHERE langtkursus.dato_start > "'.$date.'" AND langtkursus.active = 1
		AND langtkursus_tilmelding.active = 1');
if (PEAR::isError($res)) {
    die($res->getUserInfo());
}
$i = 0;
while ($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC)) {
    $tilmelding = new VIH_Model_LangtKursus_Tilmelding($row['id']);
    $subject = 'Er du i form?';
    $body = "Du er meldt til et af de kommende kurser på Vejle Idrætshøjskole. For at få mest muligt ud af dit højskoleophold, kan det være en god ide at have trænet lidt på forhånd. Man behøver på ingen måde at være en superhelt for at gå på Vejle Idrætshøjskole, men lidt træning på forhånd forebygger skader.\n\nHvis du kan få det presset ind i din hverdag, anbefaler vi at du følger nedenstående program:\n\nhttp://motionsplan.dk/exerciseprogram/showpublic/96\n\nVi glæder os til at møde dig. Hvis du har nogen spørgsmål, er du meget velkommen til at skrive til lars@vih.dk.\n\nVenlig hilsen\n\nLars Olesen\nVejle Idrætshøjskole";

    $headers = 'From: lars@vih.dk' . "\r\n" .
    'Reply-To: lars@vih.dk';

    if ($email = $tilmelding->get('email')) {
        //mail('lsolesen@gmail.com', $subject, $body, $headers);
        mail($email, $subject, $body, $headers);
        $i++;
    }
}
echo 'Sendt til' . $i;
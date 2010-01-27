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
    $body = "Du er meldt til et af de kommende kurser p� Vejle Idr�tsh�jskole. For at f� mest muligt ud af dit h�jskoleophold, kan det v�re en god ide at have tr�net lidt p� forh�nd. Man beh�ver p� ingen m�de at v�re en superhelt for at g� p� Vejle Idr�tsh�jskole, men lidt tr�ning p� forh�nd forebygger skader.\n\nHvis du kan f� det presset ind i din hverdag, anbefaler vi at du f�lger nedenst�ende program:\n\nhttp://motionsplan.dk/exerciseprogram/showpublic/96\n\nVi gl�der os til at m�de dig. Hvis du har nogen sp�rgsm�l, er du meget velkommen til at skrive til lars@vih.dk.\n\nVenlig hilsen\n\nLars Olesen\nVejle Idr�tsh�jskole";

    $headers = 'From: lars@vih.dk' . "\r\n" .
    'Reply-To: lars@vih.dk';

    if ($email = $tilmelding->get('email')) {
        //mail('lsolesen@gmail.com', $subject, $body, $headers);
        mail($email, $subject, $body, $headers);
        $i++;
    }
}
echo 'Sendt til' . $i;
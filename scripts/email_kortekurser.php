<?php
require_once 'config.local.php';
set_include_path('/home/vih/pear/php/' . PATH_SEPARATOR . get_include_path());
require_once 'Ilib/ClassLoader.php';

$date = date('Y-m-d');
//$date_sent = '2010-06-08 12:00:00';
$date_sent = '2009-05-08 12:00:00';

$db = MDB2::factory(DB_DSN);
$res = $db->query('SELECT kortkursus_tilmelding.id
    FROM kortkursus_tilmelding
    INNER JOIN kortkursus ON kortkursus.id = kortkursus_tilmelding.kortkursus_id
    WHERE kortkursus.dato_start > "'.$date.'" AND kortkursus.active = 1
        AND kortkursus_tilmelding.active = 1 AND kortkursus_tilmelding.status_key > 1 AND kortkursus_tilmelding.date_created > "'.$date_sent.'"');
if (PEAR::isError($res)) {
    die($res->getUserInfo());
}
$i = 0;
while ($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC)) {
    $tilmelding = new VIH_Model_KortKursus_Tilmelding($row['id']);
    $subject = 'Flere informationer?';
    $body = "Du er meldt til et af de kommende kurser p� Vejle Idr�tsh�jskole. Det har hjulpet at krydse fingre, for det er da i det mindste blevet varmere i vejret. Og blomsterne f�r da det vand de skal have.\n\nDet er nok ogs� ved at v�re en god ide at pudse formen lidt af. Du bliver jo nok inspireret til at r�re dig lidt mere end du er vant til p� h�jskolen. Du kan finde lidt inspiration p� http://motion-online.dk eller p� http://motionsplan.dk.\n\nVi har som tidligere n�vnt lagt alle vores korte kurser p� Facebook, og det vil v�re fedt om du p� nedenst�ende skriver at du deltager. S� har vi allerede et ansigt p� dig, inden du kommer :):\n\nhttp://www.facebook.com/pages/Vejle-Idraetshojskole/93365171887?v=app_2344061033&vm=all\n\n.\n\nDu modtager mere information om kurset senest 14 dage f�r kursusstart.\n\nVenlig hilsen\n\nLars Olesen\nVejle Idr�tsh�jskole";

    $headers = 'From: kontor@vih.dk' . "\r\n" .
    'Reply-To: kontor@vih.dk';

    if ($email = $tilmelding->get('email')) {
        //mail('lsolesen@gmail.com', $subject, $body, $headers);
        mail($email, $subject, $body, $headers);
        $i++;
    }
}
echo 'Sendt til' . $i;
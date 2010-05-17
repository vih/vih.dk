<?php
require_once 'config.local.php';
set_include_path('/home/vih/pear/php/' . PATH_SEPARATOR . get_include_path());
require_once 'Ilib/ClassLoader.php';

$date = date('Y-m-d');
$date_sent = '2010-05-08 12:00:00';


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
    $subject = 'Så er det snart sommer?';
    $body = "Du er meldt til et af de kommende kurser på Vejle Idrætshøjskole, og det er vist ved at være på tide, at vi alle krydser fingre for, at vejret bliver lidt varmere.\n\nDu kan finde alle vores korte kurser på Facebook. På nedenstående side kan du skrive om du deltager eller ej, og derved allerede på forhånd have ansigter på de andre deltagere:\n\nhttp://www.facebook.com/pages/Vejle-Idraetshojskole/93365171887?v=app_2344061033&vm=all\n\nVi glæder os til en uge med fuld fart på i Vejle.\n\nDu vil modtage mere information omkring 14 dage før kurset.\n\nVenlig hilsen\n\nLars Olesen\nVejle Idrætshøjskole";

    $headers = 'From: kontor@vih.dk' . "\r\n" .
    'Reply-To: kontor@vih.dk';

    if ($email = $tilmelding->get('email')) {
        //mail('lsolesen@gmail.com', $subject, $body, $headers);
        mail($email, $subject, $body, $headers);
        $i++;
    }
}
echo 'Sendt til' . $i;
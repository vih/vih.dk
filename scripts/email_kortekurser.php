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
    $body = "Du er meldt til et af de kommende kurser på Vejle Idrætshøjskole. Det har hjulpet at krydse fingre, for det er da i det mindste blevet varmere i vejret. Og blomsterne får da det vand de skal have.\n\nDet er nok også ved at være en god ide at pudse formen lidt af. Du bliver jo nok inspireret til at røre dig lidt mere end du er vant til på højskolen. Du kan finde lidt inspiration på http://motion-online.dk eller på http://motionsplan.dk.\n\nVi har som tidligere nævnt lagt alle vores korte kurser på Facebook, og det vil være fedt om du på nedenstående skriver at du deltager. Så har vi allerede et ansigt på dig, inden du kommer :):\n\nhttp://www.facebook.com/pages/Vejle-Idraetshojskole/93365171887?v=app_2344061033&vm=all\n\n.\n\nDu modtager mere information om kurset senest 14 dage før kursusstart.\n\nVenlig hilsen\n\nLars Olesen\nVejle Idrætshøjskole";

    $headers = 'From: kontor@vih.dk' . "\r\n" .
    'Reply-To: kontor@vih.dk';

    if ($email = $tilmelding->get('email')) {
        //mail('lsolesen@gmail.com', $subject, $body, $headers);
        mail($email, $subject, $body, $headers);
        $i++;
    }
}
echo 'Sendt til' . $i;
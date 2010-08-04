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
    $subject = 'Vil du have en udfordring?';
    $body = "Du er tilmeldt et af de kommende korte kurser på Vejle Idrætshøjskole. Vi glæder os til at se dig - og vi håber på en aktiv sommer :) Eleverne på de lange kurser er rejst, og skolen er ved at blive gjort klar til en travl og dejlig sommer.\n\nHvis du har lyst, kan du deltage i en lille udfordring, hvor det handler om at røre sig i flest minutter i løbet af sommeren. Det tæller lige meget om du går, løber, cykler eller ror. Det tæller ikke hvis du kører i bil :):\n\nhttp://www.endomondo.com/challenge/ihR2EWTL9nU\n\nDu kan læse lidt mere om Endomondo på http://motionsplan.dk/artikel/endomondo-din-motivation.\n\nHvis du har lyst, kan du også stadig klikke ind på vores Facebook-side og finde det kursus, du er tilmeldt :)\n\nhttp://www.facebook.com/pages/Vejle-Idraetshojskole/93365171887?v=app_2344061033&vm=all\n\n.\n\nHvis der er mindre end 14 dage til dit kursus starter, skulle du gerne have modtaget yderligere materiale om kurset med posten. Hvis det ikke er tilfældet, må du gerne skrive til kontor@vih.dk.\n\nVenlig hilsen\n\nLars Olesen\nVejle Idrætshøjskole";

    $headers = 'From: kontor@vih.dk' . "\r\n" .
    'Reply-To: kontor@vih.dk';

    if ($email = $tilmelding->get('email')) {
        //mail('lsolesen@gmail.com', $subject, $body, $headers);
        mail($email, $subject, $body, $headers);
        $i++;
    }
}
echo 'Sendt til' . $i;
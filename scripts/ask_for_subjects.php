<?php
//die('only run after setting up the date');
require_once 'config.local.php';
set_include_path(PATH_INCLUDE);
require_once 'Ilib/ClassLoader.php';

$date = date('Y-m-d');

$db = MDB2::factory(DB_DSN);
$res = $db->query('SELECT langtkursus_tilmelding.id FROM langtkursus_tilmelding INNER JOIN langtkursus ON langtkursus.id = langtkursus_tilmelding.kursus_id WHERE langtkursus.dato_start > "'.$date.'" AND langtkursus.active = 1 AND langtkursus_tilmelding.active = 1');
if (PEAR::isError($res)) {
    die($res->getUserInfo());
}
$i = 0;
while ($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC)) {
    $tilmelding = new VIH_Model_LangtKursus_Tilmelding($row['id']);
    $link = 'http://vih.dk/login/langekurser/' .  $tilmelding->get('code');
    $subject = 'Tjek dine fag';
    $body = 'Du er meldt til et af de kommende kurser på Vejle Idrætshøjskole. Vi sidder midt i planlægningen, og vi har brug for at vide, hvilke idrætsspecialer og linjer, du gerne vil have. Derfor beder vi dig gå ind på nedenstående link og tjekke om de rigtige fag er krydset af. Du skal vælge et fag fra hver faggruppe, og du finder linket til Dine fag nederst på siden.' . "\n\n" . $link . "\n\nVær opmærksom på, at det skyldige beløb ikke nødvendigvis er rigtigt regnet ud endnu. Det gør vores kontor hurtigst muligt. Hvis du har nogen spørgsmål, er du meget velkommen til at skrive til lars@vih.dk.\n\nVenlig hilsen\n\nLars Olesen\nVejle Idrætshøjskole";

    $headers = 'From: lars@vih.dk' . "\r\n" .
    'Reply-To: lars@vih.dk';

    if ($email = $tilmelding->get('email')) {
        mail($email, $subject, $body, $headers);
        $i++;
    }
}
echo '<br>' . $i;
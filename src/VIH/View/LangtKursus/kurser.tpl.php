<?php if (is_array($kurser) AND count($kurser) > 0): ?>

<table id="kursusoversigt" summary="<?php e($summary); ?>" class="skema">
    <caption><?php echo $caption; ?></caption>
    <thead>
    <tr>
        <th id="kursusnavn">Kursusnavn</th>
        <th id="uger">Uger</th>
        <th id="startdato">Start</th>
        <th id="slutdato" >Slut</th>
        <th id="tilmelding">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
<?php
$aarskrevet = '';
$tjekaar = '';
foreach ($kurser AS $kursus):
    if ($kursus->getYear() != $aarskrevet) {
        print '<tr class="aar"><td colspan="5">Kursusstart '.$kursus->getYear().'</td></tr>';
        $aarskrevet = $kursus->getYear();
    }

    print '<tr class="vevent">';
    print '<td headers="kursusnavn"><a class="url summary" href="'.url('/langekurser/' . $kursus->get('id')).'">' . $kursus->getKursusNavn() . '</a></td>';
    print '<td headers="uger">' . $kursus->get('ugeantal').'</td>';
    print '<td headers="startdato" class="dtstart">' . $kursus->getDateStart()->format('%d-%m-%Y') . '</td>';
    print '<td headers="slutdato" class="dtend">' . $kursus->getDateEnd()->format('%d-%m-%Y') . '</td>';
    print '<td headers="tilmelding"><a href="'.url('/langekurser/' . $kursus->get('id') . '/tilmelding').'">Tilmelding</a></td>';
    print '</tr>';

endforeach; ?>
    </tbody>
</table>

<?php else: ?>

<p class="courses-empty">
    Der er i øjeblikket ikke nogen kurser på denne søgning. Du kan <a href="<?php e(url('/nyhedsbrev/')); ?>">tilmelde dig vores nyhedsbrev</a>, hvis du vil have besked om, hvornår vi opdaterer listen igen.
</p>

<?php endif; ?>

<?php if (is_array($kurser)): ?>

<?php if (count($kurser) == 0): ?>

<p class="courses-empty">
    Der er i øjeblikket ikke nogen kurser på denne søgning. Du kan <a href="<?php echo url('/nyhedsbrev/'); ?>">tilmelde dig vores nyhedsbrev</a>, hvis du vil have besked om, hvornår vi opdaterer listen igen.
</p>

<?php else: ?>
<table id="kursusoversigt" summary="<?php echo $summary; ?>" class="skema">
    <caption><?php echo $caption; ?></caption>
    <thead>
        <tr>
            <th id="kursusnavn">Kursusnavn</th>
            <th id="uge">Uge</th>
            <th id="status">Status</th>
            <th id="tilmelding">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php $aarskrevet = ''; foreach ($kurser AS $kursus): ?>

        <?php
        if ($kursus->get('aar') != $aarskrevet) {
            print '<tr class="aar"><td colspan="4">Kursusstart '.$kursus->get('aar').'</td></tr>';
            $aarskrevet = $kursus->get('aar');
        }
        ?>

        <tr>
            <td headers="kursusnavn"><a href="<?php e(url($kursus->get('id'))); ?>"><?php e($kursus->get('navn')); ?></a></td>
            <td headers="uge"><?php e($kursus->get('uge')); ?></td>
            <td headers="status"><?php e($kursus->get('pladser_status')); ?></td>
            <td headers="tilmelding"><a href="<?php e(url($kursus->get('id') . '/tilmelding')); ?>">Tilmelding</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<?php endif; ?>

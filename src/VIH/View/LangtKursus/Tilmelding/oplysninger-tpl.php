<?php if (is_object($tilmelding)): ?>
<table>
    <caption><?php echo $caption; ?></caption>
    <tr>
        <th>Tilmelding</th>
        <td>#<?php echo $tilmelding->get('id'); ?></td>
    </tr>

    <tr>
        <th>Kursus</th>
        <td><?php echo $tilmelding->getKursus()->getKursusNavn(); ?></td>
    </tr>
    <tr>
        <th>Navn</th>
        <td><?php echo $tilmelding->get('navn'); ?></td>
    </tr>
    <tr>
        <th>CPR-nummer</th>
        <td><?php echo vih_scramble_cpr($tilmelding->get('cpr')); ?></td>
    </tr>
    <tr>
        <th>Adresse</th>
        <td><?php echo $tilmelding->get('adresse'); ?></td>
    </tr>
    <tr>
        <th>Postnummer og by</th>
        <td><?php echo $tilmelding->get('postnr'); ?>  <?php echo $tilmelding->get('postby'); ?></td>
    </tr>
    <tr>
        <th>Telefonnummer</th>
        <td><?php echo $tilmelding->get('telefon'); ?></td>
    </tr>
    <?php if ($tilmelding->get('email')): ?>
    <tr>
        <th>E-mail</th>
        <td><?php echo $tilmelding->get('email'); ?></td>
    </tr>
    <?php endif; ?>
</table>

<?php endif; ?>


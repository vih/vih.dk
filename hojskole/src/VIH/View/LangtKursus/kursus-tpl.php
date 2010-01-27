<h1><?php e($kursus->getKursusNavn()); ?></h1>

<div>
    <?php echo vih_autoop($kursus->get('beskrivelse')); ?>
</div>

<?php if (!empty($fag)): ?>

    <?php echo $fag; ?>

<?php endif; ?>
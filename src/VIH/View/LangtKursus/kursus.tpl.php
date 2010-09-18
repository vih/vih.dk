<h1><?php e($kursus->getKursusNavn()); ?></h1>

<p><a href="<?php e(url('tilmelding')); ?>">Tilmeld mig</a></p>

<div>
    <?php echo autoop($kursus->get('beskrivelse')); ?>
</div>

<?php if (!empty($fag)): ?>

    <?php echo $fag; ?>

<?php endif; ?>
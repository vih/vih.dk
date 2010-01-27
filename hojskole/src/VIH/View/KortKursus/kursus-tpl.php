<?php
/**
 * Denne skabelon skal være mærket op som microformatet hcalender, vevent
 *
 * @author Lars Olesen <lars@legestue.net>
 */
?>
<div class="vevent">
    <h1 class="summary"><?php e($kursus->get('kursusnavn')); ?></h1>
    <?php if ($kursus->get('pladser_ledige') <= 0): ?>
          <p class="notice">Der er ikke flere ledige pladser på dette kursus.</p>
    <?php elseif ($kursus->get('pladser_begyndere_ledige') <= 0 AND $kursus->get('gruppe_id') == 1): // golf ?>
          <p class="notice">Der er ikke flere ledige begynderpladser på dette kursus.</p>
      <?php endif; ?>

    <div class="description">
        <?php echo autoop($kursus->get("beskrivelse")); ?>
    </div>

     <hr />

    <div>
        <?php if ($kursusleder->get("navn")): ?>
        <strong>Kursusleder</strong> <a href="<?php e(url('/underviser/' . $kursusleder->get('id'))); ?>"><?php e($kursusleder->get("navn")); ?></a><br />
        <?php endif; ?>
        <p>
            <strong>Tidspunkt</strong>
                <abbr class="dtstart" title="<?php e($kursus->get('dato_start')); ?>"><?php e($kursus->get('dato_start_dk')); ?></abbr> til
                <abbr class="dtstart" title="<?php e($kursus->get('dato_slut')); ?>"><?php e($kursus->get('dato_slut_dk')); ?></abbr>
        </p>
        <p>
            <strong>Pris</strong> <?php echo $kursus->get('pris'); ?> kroner
            <?php if ($kursus->get('pris_boern') > 0) { echo ' for voksne og for børn ' . $kursus->get('pris_boern') . ' kroner'; } ?>
        </p>
        <div class="location">
            <strong>Indkvartering</strong>
			<ul>
            <?php
            foreach ($kursus->getIndkvartering() as $key => $indkvartering): ?>
                <li><?php e($indkvartering['text']); ?></li>
            <?php endforeach; ?>
            </ul>

        </div>
        <p><a href="<?php e(url('tilmelding')); ?>">Jeg vil gerne tilmelde mig &rarr;</a></p>
    </div>
</div>
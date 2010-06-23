<?php
$months = array(
    '01' => 'jan',
    '02' => 'feb',
    '03' => 'mar',
    '04' => 'apr',
    '05' => 'maj',
    '06' => 'jun',
    '07' => 'jul',
    '08' => 'aug',
    '09' => 'sep',
    '10' => 'okt',
    '11' => 'nov',
    '12' => 'dec'
);

?>

<?php if (is_array($nyheder)): ?>

<?php foreach ($nyheder AS $nyhed): ?>
<div class="vevent">
    <span class="dtend" title="<?php e($nyhed->get('date_iso')); ?>">
        <?php e($months[$nyhed->get('dato_month')]); ?> <span class="day"><?php e($nyhed->get('dato_day')); ?></span>
    </span>

    <h2 class="summary"><a rel="bookmark" href="<?php e(url('/nyheder/' . $nyhed->get('id'))); ?>" class="url"><?php e($nyhed->get('overskrift')); ?></a></h2>
    <p class="description"><?php e(strip_tags($nyhed->get('teaser'))); ?></p>

</div>

<?php endforeach; ?>

<?php endif; ?>
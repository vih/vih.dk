<?php foreach ($nyheder as $nyhed): ?>
    <h3><a href="<?php e(url('/nyheder/' . $nyhed->get('id'))); ?>"><?php e($nyhed->get('overskrift')); ?></a></h3>
    <p><?php e(strip_tags($nyhed->get('teaser'))); ?></p>
<?php endforeach; ?>
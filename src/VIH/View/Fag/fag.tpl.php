<?php if (is_array($fag)): ?>
    <ul>
        <?php foreach($fag AS $f): ?>
        <li><a href="<?php e(url('/fag/' . $f->get('identifier'))); ?>"><?php e($f->get('navn')); ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
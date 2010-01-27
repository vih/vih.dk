<?php if (is_array($faciliteter)): ?>
    <ul>
    <?php foreach($faciliteter AS $facilitet): ?>
        <li><a href="<?php e(url('../' . $facilitet->get('id'))); ?>"><?php e($facilitet->get('navn')); ?></a></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php if (is_array($faciliteter)): ?>
    <dl id="faciliteter">
        <dt>Faciliteter</dt>
        <?php foreach($faciliteter AS $facilitet): ?>
            <dd><a id="f<?php e($facilitet->get('id')); ?>" href="<?php e(url($facilitet->get('id'))); ?>"><?php e($facilitet->get('navn')); ?></a></dd>
        <?php endforeach; ?>
    </dl>
<?php endif; ?>
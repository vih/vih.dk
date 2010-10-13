<?php if (!empty($undervisere) AND is_array($undervisere)): ?>

    <dl id="undervisere">

    <?php foreach ($undervisere AS $underviser): ?>
        <dt class="vcard"><a class="url fn" href="<?php e(url('/underviser/' . $underviser->get('id'))); ?>"><?php e($underviser->get('navn')); ?></a></dt>
    <?php endforeach; ?>

    </dl>

<?php endif; ?>
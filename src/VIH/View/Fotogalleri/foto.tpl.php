

<div style="height: <?php e($photo['instance']['instance_properties']['max_height']); ?>; text-align: center;">
    <img src="<?php e(url('/file.php') . $photo['instance']['file_uri_parameters']); ?>" width="<?php e($photo['instance']['width']); ?>" height="<?php e($photo['instance']['height']); ?>" />
</div>

<?php if (!empty($photo['description'])): ?>
    <div style="text-align: center;"><?php e($photo['description']); ?></div>
<?php endif; ?>

<div style="text-align: center;">
    <?php if (!empty($previous)): ?>
        <a href="<?php e($previous); ?>">&lt;&lt;</a>
    <?php else: ?>
        <span style="color:#ddd;">&lt;&lt;</span>
    <?php endif; ?>

    <?php if (!empty($next)): ?>
        <a href="<?php e($next); ?>">&gt;&gt;</a>
    <?php else: ?>
        <span style="color:#ddd;">&gt;&gt;</span>
    <?php endif; ?>
</div>

<div style="text-align: right;">
    <?php if (!empty($list)): ?>
        <a href="<?php e($list); ?>">Tilbage til liste</a>
    <?php endif; ?>

</div>
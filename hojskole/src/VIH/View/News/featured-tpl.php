<?php if (is_array($nyheder)): ?>

<div id="news-featured">

	<div class="news-item left">
		<span class="dtend" title="<?php e($nyheder[0]->get('date_iso')); ?>">
			<span class="day"><?php e($nyheder[0]->get('dato_day')); ?></span>/<?php e($nyheder[0]->get('dato_month')); ?>
		</span>
		<a href="<?php e(url('/nyheder/'. $nyheder[0]->get('id'))); ?>/"><?php e($nyheder[0]->get('overskrift')); ?></a>
	</div>

	<div class="news-item right">
		<span class="dtend" title="<?php e($nyheder[1]->get('date_iso')); ?>">
			<span class="day"><?php echo $nyheder[1]->get('dato_day'); ?></span>/<?php e($nyheder[1]->get('dato_month')); ?>
		</span>

		<a href="<?php e(url('/nyheder/' . $nyheder[1]->get('id'))); ?>/"><?php e($nyheder[1]->get('overskrift')); ?></a>
	</div>

</div>

<?php endif; ?>
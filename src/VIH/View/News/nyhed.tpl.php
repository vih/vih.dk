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
<?php if (is_object($news)): ?>

<div class="vevent">
	<p class="keywords" style="text-transform: uppercase; font-weight: bold; color: #bbb; margin-bottom: 0;">
		<?php e($news->get('kategori')); ?>
	</p>

	<span class="dtend" title="<?php e($news->get('date_iso')); ?>" style="float:right; margin-right: 0; margin-left: 1em;">
		<?php e($months[$news->get('dato_month')]); ?> <span class="day"><?php e($news->get('dato_day')); ?></span>
	</span>

	<h1 style="margin-top: 0;" class="summary"><?php e($news->get('overskrift')); ?></h1>

	<div class="description">
		<?php echo autoop($news->get('tekst')); ?>
	</div>

</div>

<?php endif; ?>
<?php if (is_array($special_days)): ?>
	<?php if (count($special_days) > 0): ?>

		<table>
			<?php foreach ($special_days AS $ansat): ?>
				<tr>
					<td><?php echo $ansat->get('navn'); ?> har f�dselsdag i dag.</td>
				</tr>
			<?php endforeach; ?>
		</table>

	<?php endif; ?>
<?php endif; ?>
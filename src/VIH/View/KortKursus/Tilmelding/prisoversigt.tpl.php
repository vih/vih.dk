<?php if (is_object($tilmelding)): ?>
<table summary="Prisoversigt" id="betalingsoversigt">
	<caption>Prisoversigt</caption>
	<tr>
		<th>Samlet kursuspris</th>
		<td><?php e((float)$tilmelding->get('pris_kursuspris')); ?></td>
	</tr>
	<?php if ($tilmelding->get('pris_forsikring') > 0): ?>
		<tr>
			<th>Afbestillingsforsikring</th>
			<td>+ <?php e($tilmelding->get('pris_forsikring')); ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($tilmelding->get('rabat') > 0): ?>
		<tr>
			<th>Rabat</th>
			<td>- <?php e($tilmelding->get('rabat')); ?></td>
		</tr>
	<?php endif; ?>
	<tr>
		<th>Samlet pris</th>
		<td><?php e((float)$tilmelding->get('pris_total')); ?></td>
	</tr>
	<?php if ($tilmelding->get('dato_forfalden') > date('Y-m-d')): ?>
		<tr>
			<th>Depositum</th>
			<td><?php e((float)$tilmelding->get('pris_depositum')); ?></td>
		</tr>
		<?php if ($tilmelding->get('pris_forudbetaling') != $tilmelding->get('pris_depositum')): ?>
		<tr>
			<th>Forudbetaling</th>
			<td><?php e((float)$tilmelding->get('pris_forudbetaling')); ?></td>
		</tr>
		<?php endif; ?>
	<?php endif; ?>
	<tr>
		<th>Betalt</th>
		<td>
			<?php e((float)$tilmelding->get('betalt')); ?>
			<?php if (count($tilmelding->betaling->getList('not_approved'))): $mark = true; ?>
			*
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<th>Skyldig</th>
		<td><?php e((float)$tilmelding->get('skyldig')); ?></td>
	</tr>
</table>
<?php if (isset($mark)): ?>
<p class="notice">* Der er afventende betalinger. Oversigten opdateres, når vi har hævet pengene.</p>
<?php endif; ?>

<?php endif; ?>

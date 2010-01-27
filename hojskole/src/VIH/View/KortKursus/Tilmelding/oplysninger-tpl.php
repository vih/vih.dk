<?php if (is_object($tilmelding)): ?>

<table summary="Oplysninger om din ordre">
	<caption><?php e($caption); ?></caption>
	<tr>
		<th>Tilmeldingsnummer</th>
		<td><?php e($tilmelding->get('id')); ?></td>
	</tr>
	<tr>
		<th>Tilmeldingsdato</th>
		<td><?php e($tilmelding->get('date_created_dk')); ?></td>
	</tr>
	<tr>
		<th>Kursus</th>
		<td><?php e($tilmelding->get('kursusnavn')); ?></td>
	</tr>
	<tr>
		<th>Kontaktperson</th>
		<td><?php e($tilmelding->get('navn')); ?></td>
	</tr>
	<tr>
		<th>Adresse</th>
		<td><?php e($tilmelding->get('adresse')); ?></td>
	</tr>
	<tr>
		<th>Postnr. og by</th>
		<td><?php e($tilmelding->get('postnr') . '  ' . $tilmelding->get('postby')); ?></td>
	</tr>
	<tr>
		<th>E-mail</th>
		<td><?php e($tilmelding->get('email')); ?></td>
	</tr>
</table>

<?php endif; ?>


<h1>Tilmelding</h1>

<?php if (!empty($error)): ?>
<ul>
<?php foreach ($error as $e): ?>
	<li><?php echo e($e); ?></li>
<?php endforeach;?>
<ul>
<?php endif; ?>

<form action="<?php echo basename($_SERVER['PHP_SELF']); ?>"
method="POST">
<table>
<tr>
	<th>Antal</th>
	<th>Produkt</th>
	<th>Pris</th>
</tr>
<?php if (!empty($jubilaeum)): ?>
<?php foreach ($jubilaeum as $item): ?>

	<tr>
	<td><input type="text" name="jubilaeum[<?php echo e($item['id']); ?>]" size="2" /></td>
	<td><a href="view.php?id=<?php echo e($item['id']); ?>"><?php echo e($item['name']); ?></a></td>
	<td><?php echo e($item['price']); ?> kr</td>
	</tr>

<?php endforeach; ?>
<?php endif; ?>

<?php if (!empty($elevmoede) and empty($jubilaeum)): ?>
<?php foreach($elevmoede as $item) { ?>
  <tr>
	<td><input type="text" name="elevmoede[<?php echo e($item['id']); ?>]" size="2" /></td>
	<td><a href="view.php?id=<?php echo e($item['id']); ?>"><?php echo e($item['name']); ?></a></td>
	<td><?php echo e($item['price']); ?> kr</td>
	</tr>
<?php } ?>
<?php endif; ?>
</table>
<input type="submit" value="Tilmeld" />
</form>

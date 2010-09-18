<h1>Rejser</h1>

<table>
<?php while ($rejse = $rejser->fetchRow(MDB2_FETCHMODE_ASSOC)): ?>
<tr>
    <td>
        <?php echo $context->getPictureHTML($rejse['identifier']); ?>
    </td>
    <td>
        <h2><?php e($rejse['navn']); ?></h2>
        <?php echo autoop($rejse['kort_beskrivelse']); ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
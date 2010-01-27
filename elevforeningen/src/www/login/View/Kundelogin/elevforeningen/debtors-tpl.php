<?php if (is_array($debtors) AND count($debtors) > 0): ?>
<table>
    <caption><?php echo $caption; ?></caption>
    <thead>
    <tr>
        <th>Nummer</th>
        <th>Dato</th>
        <th>Name</th>
        <th>At betale</th>
        <th>Betalt</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($debtors AS $debtor):  ?>
    <?php
      $options = array(
        'prefix' => 'shop.',
        'encoding' => 'iso-8859-1', 'debug' => false);
      $client = XML_RPC2_Client::create('http://www.intraface.dk/xmlrpc/onlinepayment/server.php', $options);
      $info = $client->getPaymentTarget($credentials, $debtor['identifier_key']);
    ?>

        <tr>
            <td><?php echo $debtor['number']; ?></td>
            <td><?php echo $debtor['description']; ?></td>
            <td><?php echo $debtor['dk_this_date']; ?></td>
            <td><?php echo $debtor['total']; ?></td>
            <td>
                <?php
                if (empty($debtor['where_to_id'])) {
                    echo $debtor['payment_total'];
                } else {
                    echo '&mdash;';
                }
                ?>
            </td>
            <td><?php
                if (empty($debtor['where_to_id'])) {
                    $skyldig = $debtor['total'] - $debtor['payment_total'];
                    if ($skyldig == 0) {
                        echo 'Betalt';
                    } elseif ($skyldig > 0 AND isset($info['payment_online']) AND $info['payment_online'] > 0) {
                        echo '<strong style="color: green;">Der er afventende betalinger: ' . number_format($info['payment_online'], 0, ',', '.') . ' kroner. Vi godkender den hurtigst muligt.</strong>';
                    } elseif ($debtor['type'] == 'invoice') {
                        echo 'Du skylder ' . number_format($skyldig, 0, ',', '.') . ' kroner. <a href="betaling.php?order_id='.$debtor['id'].'">Betaling &rarr;</a>';
                    } else {
                        echo 'Oprettet';
                    }
                } else {
                    echo 'Behandlet';
                }
                ?>
            </td>

            <td>
		<?php
		/*
                <?php if (isset($skyldig) AND $skyldig == 0): ?>
                <a href="<?php e(url($debtor['id'])); ?>">Kvittering</a>
                <?php else: ?>
                <a href="<?php e(url($debtor['id'])); ?>">Se ordre</a>
                <?php endif; ?>
		*/
		?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

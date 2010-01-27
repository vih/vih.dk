<h1>Indkøbskurv</h1>

<?php if (is_array($items) AND count($items) > 0): ?>
<form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST">
    <table id="basket">
        <caption>Kurv (priser incl. moms)</caption>
        <thead>
            <tr>
                <th></th>
                <th>Navn</th>
                <th>Antal</th>
                <th>Beløb</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td class="help" colspan="2">Du kan ændre antallet af varer ved at rette antallet og opdatere kurven.</td>
                <td class="total"><strong>I alt</strong></td>
                <td class="total" style="text-align: right;">DKK <?php echo $total_price; ?></td>
            </tr>
        </tfoot>

        <tbody>
        <?php foreach($items AS $item): ?>
            <tr>
                <td class="picture">
                    <?php if (array_key_exists(0, $item['pictures'])): ?>
                        <img src="<?php echo $item['pictures'][0]['thumbnail']['file_uri']; ?>" alt="<?php echo $item["name"]; ?>" height="<?php echo $item['pictures'][0]['thumbnail']['height']; ?>" width="<?php echo $item['pictures'][0]['thumbnail']['width']; ?>" />
                    <?php endif; ?>
                </td>
                <td class="name"><?php echo $item["name"]; ?>
                </td>
                <td class="quantity">
                	<?php
                    if (!empty($item["basketevaluation_product"]) AND $item["basketevaluation_product"] == 1) {
                    	// not possible to change data
                    }
                    else {
                        echo '<input type="text" size="2" value="'.$item["quantity"].'" name="basket_quantity['.$item["id"].']" />';
                    }
                    ?>
                </td>
                <td class="price">DKK <?php echo $item["totalprice_incl_vat"]; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</table>
<input type="submit" value="Opdater" name="update" />
</form>

<?php else: ?>
    <p>Der er ikke nogen varer i indkøbskurven. <a href="tilmelding.php">Gå til oversigten &rarr;</a></p>
<?php endif; ?>

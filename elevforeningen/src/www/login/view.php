<?php
require('include_elevforeningen_login.php');

$client = new IntrafacePublic_Shop_XMLRPC_Client($credentials, false);
$product = utf8_decoding($client->getProduct($_GET['id']));

$basket = $client->getBasket();
$selected_items = $basket['items'];
$value = '';
if (is_array($selected_items) AND count($selected_items) > 0) {
    foreach ($selected_items AS $item) {
        if ($product['id'] == $item['product_id']) {
            $value = $item['quantity'];
        }
    }
}
//
$pic = '';

if (isset($product['pic_id']) AND $product['pic_id'] > 0) {
    $pic = '<img src="'.$product['fileviewer'].'" alt="" style="float: right;" />';
}

$tpl = new Template(PATH_TEMPLATE_KUNDELOGIN);
$tpl->set('title', 'Tilmelding');
$tpl->set('content_main', '
    <h1>'.$product['name'].'</h1>
    '.$pic.'
    '.nl2br($product['description']).'<br /><br />
    <form action="bestilling.php" method="post">
        <label for="order_id">Antal
            <input type="text" name="order['.$product['id'].']" id="order_id" value="'.$value.'" size="2" />
        </label>
        <input type="submit" value="Bestil" />
    </form>
');
echo $tpl->fetch('main-tpl.php');


?>
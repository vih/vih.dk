<?php
/**
 * Used when only one type of product is sold for instance aarsskrift.
 */
require 'include_elevforeningen_login.php';

$contact = $auth->getContact($_SESSION['contact_id']);

$error = array();

if (!empty($_POST)) {
    if(is_array($_POST['order'])) {
        foreach($_POST['order'] AS $key => $antal) {
            if (isset($antal) AND is_numeric((int)$antal)) {
                $client->changeBasket($key, (int)$antal);
            }
            else {
                $error[] = 'Du skal skrive et tal, hvis du vil bestille noget.';
            }
        }
    }

    if (empty($error) AND count($error) == 0) {
        header('Location: basket.php');
        exit;
    }
}

$client = new IntrafacePublic_Shop_XMLRPC_Client($credentials);
$products = $client->getProducts(array('keywords' => array(225)));

$products_tpl = new Template(PATH_TEMPLATE);
$products_tpl->set('products', $products);
$products_tpl->set('selected_items', $client->getBasket());

$string = $products_tpl->fetch('elevforeningen/products-tpl.php');

$tpl = new Template(PATH_TEMPLATE_KUNDELOGIN);
$tpl->set('title', 'Tilmelding');
$tpl->set('content_main', $string);
echo $tpl->fetch('main-tpl.php');

?>
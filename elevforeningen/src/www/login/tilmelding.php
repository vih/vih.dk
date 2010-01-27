<?php
require 'include_elevforeningen_login.php';

$contact = $auth->getContact($_SESSION['contact_id']);

$client = new IntrafacePublic_Shop_XMLRPC_Client($credentials, false);

$error = array();

if (!empty($_POST)) {
    if(!empty($_POST['elevmoede'])) {
        foreach($_POST['elevmoede'] AS $key => $antal) {
            if (isset($antal) AND is_numeric($antal)) {
                $client->changeBasket($key, (int)$antal);
            }
            elseif (!empty($antal) AND !is_numeric($antal)) {
                $error[] = 'Du skal skrive et tal, når du tilmelder dig elevmødet.';
            }
        }
    }
    if(!empty($_POST['jubilaeum']) AND is_jubilar($auth)) {
        foreach($_POST['jubilaeum'] as $key => $antal) {
            if (isset($antal) AND is_numeric($antal)) {
                $client->changeBasket($key, (int)$antal);
            }
            elseif (!empty($antal) AND !is_numeric($antal)) {
                $error[] = 'Du skal skrive et tal, når du tilmelder dig jubilæet';
            }
        }
    }
    if(!empty($_POST['stjernetraef'])) {
        // sørger for at slette alle tilmeldinger med stjernetræf
        $stjernetraef = $client->getProducts(array('keywords' => array(122)));
        foreach ($stjernetraef['products'] AS $product) { // 122 er stjernetræf
            $client->changeBasket($product['id'], 0);
        }
        $client->changeBasket($_POST['stjernetraef'], 1);
    }

    if (empty($error) AND count($error) == 0) {
        header('Location: basket.php');
        exit;
    }
}

$basket = $client->getBasket();

$elevmoede = $client->getProducts(array('keywords' => array(121)));
$stjernetraef = $client->getProducts(array('keywords' => array(122)));
$jubilaeum = $client->getProducts(array('keywords' => array(120)));

$tilmelding_tpl = new Template(PATH_TEMPLATE);
$tilmelding_tpl->set('error', $error);
$tilmelding_tpl->set('items', utf8_decoding($basket['items']));
$tilmelding_tpl->set('elevmoede', utf8_decoding($elevmoede['products']));
$tilmelding_tpl->set('stjernetraef', utf8_decoding($stjernetraef['products']));
if (is_jubilar($auth)) {
    $tilmelding_tpl->set('jubilaeum', utf8_decoding($jubilaeum['products']));
} else {
    $tilmelding_tpl->set('jubilaeum', '');
}
$basket = $client->getBasket();

$tilmelding_tpl->set('selected_items', $basket['items']);

$tpl = new Template(PATH_TEMPLATE_KUNDELOGIN);
$tpl->set('title', 'Tilmelding');
$tpl->set('content_main', $tilmelding_tpl->fetch('elevforeningen/tilmelding-tpl.php'));
echo $tpl->fetch('main-tpl.php');


?>
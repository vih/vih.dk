<?php
define('DRUPAL_ROOT', getcwd());
// Bootstrap Drupal
require 'includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

$result = db_query('SELECT * FROM {nyhed} WHERE active = :active', array(':active' => 1), array('target' => 'vih'));

function autoop($text)
{
    require_once 'markdown.php';
    require_once 'smartypants.php';
    $text = MarkDown($text);
    $text = SmartyPants($text);
    return $text;
}

foreach ($result as $row) {
    $node = new stdClass();
    $node->title = $row->overskrift;
    $node->body['und'][0] = array(
        'value' => autoop($row->tekst),
        'safe_value' => autoop($row->tekst),
        'summary' => '',
        'safe_summary' => '',
        'format' => 'full_html');
    $node->type = 'story'; // Your specified content type
    $node->created = strtotime($row->date_created);
    $node->changed = strtotime($row->date_updated);
    $node->status = 1;
    $node->promote = 1;
    $node->sticky = 0;
    $node->format = 'full_html';
    $node->uid = 1; // UID of content owner
    $node->language = 'da';
    // If known, the taxonomy TID values can be added as an array.
    //$node->taxonomy = array(2,3,1);

    node_save($node);
}
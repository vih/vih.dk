<?php
require_once 'Template/Template.php';

class VIH_Frontend_Kursuscenter extends Template
{
    function __construct()
    {
        parent::Template(dirname(__FILE__) . '/kursuscenter/');
    }
}
?>
<?php
require('include_elevforeningen_login.php');

if ($auth->logout()) {
    header('Location: login.php');
    exit;
}


?>
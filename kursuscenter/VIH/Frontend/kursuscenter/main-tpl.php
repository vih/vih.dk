<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $meta['description']; ?>" />
        <meta name="keywords" content="<?php echo $meta['keywords']; ?>" />
        <meta name="verify-v1" content="4r4MQ/SQvVdgtEm6Im+uaPclTV0YeQv8XGd7Mw24TTk=" />
        <style type="text/css">
            @import "layout.css";
        </style>

    </head>

    <body<?php if (!empty($body_class)) echo ' class="'.$body_class.'"'; ?>>

        <div id="container">

            <div id="branding">
                <h1><a href="./">Vejle Idrætshøjskoles Kursuscenter</a></h1>
                <div id="branding-logo">
                </div>
            </div>

            <div id="search">
            </div>

            <div id="navigation-main">
                <ul>
                    <li><a href="./">Forside</a></li>
                    <li><a href="produkter.php">Produkter</a></li>
                    <li><a href="faciliteter.php">Faciliteter</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                    <li><a href="om.php">Om kursuscenteret</a></li>
                </ul>
            </div>

            <div id="navigation-section">
            </div>

            <div id="breadcrumb">
            </div>

            <div id="content">
                <div id="content-main">
                    <?php if (!empty($content_main)) echo $content_main; ?>
                </div>
                <div id="content-sub">
                    <?php if (!empty($content_sub)) echo $content_sub; ?>
                </div>
            </div>

            <div id="siteinfo">
                <div id="siteinfo-legal">
                    &copy; www.vih.dk/kursuscenter
                </div>
            </div>


        </div>

    </body>

</html>

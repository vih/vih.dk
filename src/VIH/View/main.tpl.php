<?php
/**
 * P3P
 * Oplysninger:    http://www.sitepoint.com/article/p3p-cookies-ie6/2
 * Genereret med:  http://www.p3pwiz.com/
 *
 * @author Lars Olesen <lars@legestue.net>
 */
header('P3P: policyref="' . $this->url('/w3c/p3p.xml') . '", CP="NID DSP ALL COR"');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Vejle Idrætshøjskole: <?php e($title); ?></title>
        <meta name="description" content="<?php e($this->document->meta['description']); ?>">
        <meta name="keywords" content="<?php e($this->document->meta['keywords']); ?>">
        <link href="<?php e($this->url('/css/main.css')); ?>" rel="stylesheet" media="screen, projection" type="text/css">
        <!--[if IE ]>
        <link href="<?php e($this->url('/css/iecss.css')); ?>" rel="stylesheet"  media="screen,projection" type="text/css">
        <![endif]-->
        <link href="<?php e($this->url('/css/print.css')); ?>" rel="stylesheet" media="print" type="text/css">

        <?php foreach ($this->document->styles as $style) : ?>
        <link href="<?php e($style); ?>" rel="stylesheet" media="screen" type="text/css">
        <?php endforeach; ?>

        <?php foreach ($this->document->scripts as $script) : ?>
        <script type="text/javascript" src="<?php e($script); ?>"></script>
        <?php endforeach; ?>
        <?php foreach ($this->document->feeds as $feed) : ?>
        <link rel="alternate" type="application/rss+xml" title="<?php e($feed['title']); ?>" href="<?php e($feed['link']); ?>">
        <?php endforeach; ?>
        <meta name="verify-v1" content="4r4MQ/SQvVdgtEm6Im+uaPclTV0YeQv8XGd7Mw24TTk=" />
    </head>

    <body id="<?php e($this->document->body_id); ?>" class="<?php e($this->document->body_class . ' ' . $this->document->theme); ?>">
        <div id="outer">
        <ul class="flags">
            <li class="dan"><a title="Danish" href="<?php e(url('/')); ?>">Dansk<em></em></a></li>
            <li class="eng"><a title="English" href="<?php e(url('/language')); ?>">English<em></em></a></li>
        </ul>

            <div class="top">
            <?php echo $this->getHighlight(); ?>
            </div>

            <?php echo $content; ?>
        </div>

    <?php if ($this->document->protocol != 'https'): ?>
    <script type="text/javascript">
        var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
        document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
        var pageTracker = _gat._getTracker("UA-4137620-1");
        pageTracker._initData();
        pageTracker._trackPageview();
    </script>
    <?php endif; ?>
    </body>
</html>
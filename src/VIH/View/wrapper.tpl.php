<div id="content-main" style="<?php e('background-image: url(' . $widepicture); ?>)">
    <?php echo $content; ?>
</div>
<div id="col3">
    <h2>Sidelinjen<em></em></h2>
    <div class="col3inner">
    <?php
        $news = array('nyheder' => VIH_News::getList(2));
        $creator = $context->createComponent('k_TemplateFactory');
        $tpl = $creator->create('News/sidebar-featured');
        echo $tpl->render($this, $news);
    ?>
    </div>
</div>

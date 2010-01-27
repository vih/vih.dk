<div id="content-main" style="<?php e('background-image: url(' . $this->document->widepicture); ?>)">
    <?php echo $content; ?>
</div>
<div id="col3">
    <h2>Sidelinjen<em></em></h2>
    <div class="col3inner">
    <?php
        $news = array('nyheder' => VIH_News::getList(2));
        echo $this->render('VIH/View/News/sidebar-featured.tpl.php', $news);
    ?>
    </div>
</div>

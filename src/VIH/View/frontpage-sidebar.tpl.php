<p class="brochure"><img src="<?php e(url('/gfx/images2/bgTimeoutMagasin.jpg')); ?>" alt="Time Out" width="185" height="206"></p>

<h2>Sidelinjen<em></em></h2>

<p class="download">
    <a href="<?php e(url('/gfx/folder/timeout2009.pdf')); ?>">Download og læs <br> vores magasin</a>
</p>

<div class="col3inner">
    <?php echo $nyheder; ?>

    <!--
    <h3><a href="<?php e(url('/langekurser/elevchat')); ?>">Chat med en elev</a></h3>
    -->

    <h3>Næste kurser</h3>
    <?php foreach ($kurser as $kursus): ?>
        <p><a href="<?php e(url('/langekurser/' . $kursus->get('id'))); ?>"><?php e($kursus->get('navn') . ' starter '.$kursus->getDateStart()->format('%e. ') . strtolower(t($kursus->getDateStart()->format('%B'))). $kursus->getDateStart()->format(' %Y')); ?></a></p>
    <?php endforeach; ?>
</div>



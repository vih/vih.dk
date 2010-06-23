<div class="content2">
    <h1><span>Højskole &mdash; skole for livet</span></h1>
    <p>At være på idrætshøjskole handler om at udfordre og udvikle sig selv, kunne rumme andre og se mulighederne. Livsglæde udleves ikke på sofaen, men i et aktivt liv, hvor man involverer sig og har energien til at gøre en forskel. Så velkommen på vih.dk. Håber at du vil blive inspireret de næste minutter...</p>

    <ul id="pakker">
    <?php if (!empty($packages)): foreach ($packages as $package): ?>
        <li><a id="<?php e($package); ?>" href="<?php e(url('/fag/pakke/' . $package)); ?>"><span></span><strong><?php e(t($package)); ?></strong></a></li>
    <?php endforeach; endif; ?>
    </ul>
</div>
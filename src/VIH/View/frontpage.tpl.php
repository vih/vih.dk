<div class="content2">
    <h1><span>H�jskole &mdash; skole for livet</span></h1>
    <p>At v�re p� idr�tsh�jskole handler om at udfordre og udvikle sig selv, kunne rumme andre og se mulighederne. Livsgl�de udleves ikke p� sofaen, men i et aktivt liv, hvor man involverer sig og har energien til at g�re en forskel. S� velkommen p� vih.dk. H�ber at du vil blive inspireret de n�ste minutter...</p>

    <ul id="pakker">
    <?php if (!empty($packages)): foreach ($packages as $package): ?>
        <li><a id="<?php e($package); ?>" href="<?php e(url('/fag/pakke/' . $package)); ?>"><span></span><strong><?php e(__($package)); ?></strong></a></li>
    <?php endforeach; endif; ?>
    </ul>
</div>
<?php
$packages = array('politi', 'fitness', 'outdoor', 'boldspil');
?>

<div class="content2">
    <h1><span>Højskole &mdash; skole for livet</span></h1>
    <p>At være på idrætshøjskole handler om at udfordre og udvikle sig selv, kunne rumme andre og se mulighederne. Livsglæde udleves ikke på sofaen, men i et aktivt liv, hvor man involverer sig og har energien til at gøre en forskel. Så velkommen på vih.dk. Håber at du vil blive inspireret de næste minutter...</p>

    <ul id="pakker">
    <?php if (!empty($packages)): foreach ($packages as $package): ?>
        <li><a id="<?php e($package); ?>" href="<?php e(url('/fag/pakke/' . $package)); ?>"><span></span><strong><?php e(__($package)); ?></strong></a></li>
    <?php endforeach; endif; ?>
    </ul>

            <!--
            Vi plejer at sige, at det er ambitiøse mennesker, der vælger et ophold på Vejle Idrætshøjskole. Vi har sporten som ramme, men bag den ligger det, at få udviklet en række personlige og sociale kvaliteter.
            <ul class="questions">
                <li><a class="when" href="'.$this->url('/langekurser/').'">Hvornår kan jeg starte?</a></li>
                <li><a class="what" href="'.$this->url('/fag/').'">Hvad kan jeg vælge?</a></li>
            </ul>
            -->
            <!--
                <p>En <a href="'.$this->url('hojskole').'">højskole</a> er den perfekte ramme at sparke lidt til livet i &mdash; og vi har <a href="'.url('/underviser/').'">underviserne</a> og <a href="'.url('/faciliteter/').'">faciliteterne</a> til det. Vil du være med? Vi tilbyder både <a href="'.url('/langekurser/').'">lange</a> og <a href="'.url('/kortekurser/').'">korte</a> højskolekurser. Ring til os på 75820811 og få en forklaring eller <a href="'.url('/info/').'">læs mere om os</a>.</p>
            -->
</div>
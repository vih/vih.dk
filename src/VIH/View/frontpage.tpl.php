<?php
$packages = array('politi', 'fitness', 'outdoor', 'boldspil');
?>

<div class="content2">
    <h1><span>H�jskole &mdash; skole for livet</span></h1>
    <p>At v�re p� idr�tsh�jskole handler om at udfordre og udvikle sig selv, kunne rumme andre og se mulighederne. Livsgl�de udleves ikke p� sofaen, men i et aktivt liv, hvor man involverer sig og har energien til at g�re en forskel. S� velkommen p� vih.dk. H�ber at du vil blive inspireret de n�ste minutter...</p>

    <ul id="pakker">
    <?php if (!empty($packages)): foreach ($packages as $package): ?>
        <li><a id="<?php e($package); ?>" href="<?php e(url('/fag/pakke/' . $package)); ?>"><span></span><strong><?php e(__($package)); ?></strong></a></li>
    <?php endforeach; endif; ?>
    </ul>

            <!--
            Vi plejer at sige, at det er ambiti�se mennesker, der v�lger et ophold p� Vejle Idr�tsh�jskole. Vi har sporten som ramme, men bag den ligger det, at f� udviklet en r�kke personlige og sociale kvaliteter.
            <ul class="questions">
                <li><a class="when" href="'.$this->url('/langekurser/').'">Hvorn�r kan jeg starte?</a></li>
                <li><a class="what" href="'.$this->url('/fag/').'">Hvad kan jeg v�lge?</a></li>
            </ul>
            -->
            <!--
                <p>En <a href="'.$this->url('hojskole').'">h�jskole</a> er den perfekte ramme at sparke lidt til livet i &mdash; og vi har <a href="'.url('/underviser/').'">underviserne</a> og <a href="'.url('/faciliteter/').'">faciliteterne</a> til det. Vil du v�re med? Vi tilbyder b�de <a href="'.url('/langekurser/').'">lange</a> og <a href="'.url('/kortekurser/').'">korte</a> h�jskolekurser. Ring til os p� 75820811 og f� en forklaring eller <a href="'.url('/info/').'">l�s mere om os</a>.</p>
            -->
</div>
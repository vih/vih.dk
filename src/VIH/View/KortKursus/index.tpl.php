<h1><?php e($headline); ?></h1>

<ul id="nav">
    <li><a class="all" href="<?php e(url('./')); ?>">Alle kurser</a></li>
    <li><a class="golf" href="<?php e(url('golf')); ?>">Golf &amp; Højskole</a></li>
    <li><a class="camp" href="<?php e(url('camp')); ?>">IdrætsCamp</a></li>
    <li><a class="familiekursus" href="<?php e(url('familiekursus')); ?>">Familiekursus</a></li>
    <li><a class="cykel" href="<?php e(url('cykel')); ?>">Cykel &amp; Højskole</a></li>
    <li><a class="sommerhojskole" href="<?php e(url('sommerhojskole')); ?>">Sommerhøjskole</a></li>
</ul>

<p style="clear: both;" class="manchet"><?php echo $text; ?></p>

<?php echo $table; ?>
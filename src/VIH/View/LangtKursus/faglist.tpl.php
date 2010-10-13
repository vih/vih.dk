<div id="fag">
<?php
$list = '';
$test = '';
$testperiode = '';
$testfag = '';

if (!empty($fag) AND is_array($fag)):
foreach ($fag as $f):

    if ($f->getFag()->get('navn') == $testfag) continue;

    if ($f->getPeriode()->getDescription() != $testperiode) {
        $test = '';
        if ($f->getPeriode()->getDescription() == '') {
            echo '<h2 class="faglist">Andre fag</h2>';
        } else {
            echo '<h2 class="faglist">' . $f->getPeriode()->getDescription() . '</h2>';
        }
    }

    if (!$f->getFag()->get('published')) continue;
    if ($f->getFag()->get('faggruppe') != $test) {
        echo '<h3 class="faglist-group">' . $f->getFag()->get('faggruppe') . '</h3>';
        //echo '<p>'.$f->get('faggruppe_beskrivelse').'</p>';
    }

    echo '<ul>';
    echo '<li><a href="'.url('/fag/' . $f->getFag()->get('identifier')).'">'.$f->getFag()->get('navn').'</a></li>';
    echo '</ul>';

    $test = $f->getFag()->get('faggruppe');
    $testperiode = $f->getPeriode()->getDescription();
    $testfag = $f->getFag()->get('navn');
endforeach;
endif;
?>
</div>
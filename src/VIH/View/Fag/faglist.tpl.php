<div id="fag">
<?php
$list = '';
$test = '';
if (!empty($fag) AND is_array($fag)):

foreach ($fag as $f):

    if (!$f->get('published')) {
        continue;
    }
    if ($f->get('faggruppe') != $test) {
        if (isset($test_ul)) {
        	echo '</ul>';
        }
        echo '<h2>' . $f->get('faggruppe') . '</h2>';
        $test_ul = 'test';
        echo '<ul>';
        //echo '<p>'.$f->get('faggruppe_beskrivelse').'</p>';
    }

    echo '<li>';
    echo '<a href="'.url('/fag/' . $f->get('identifier')).'">'.$f->get('navn').'</a>';
    echo '</li>';

    $test = $f->get('faggruppe');
endforeach;

endif;
?>
</ul>
</div>
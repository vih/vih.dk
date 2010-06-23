<?php
$i = 0;
?>
<div class="fotogalleri">
<?php foreach($photos AS $photo): ?>
    <?php
    if($i >= 15) break;
    /*
    if($i == 5) {
        echo '<span style="width:'.$photo['instance']['width'].'; height:'.$photo['instance']['height'].'">Tekst</span>';
    }
    */
    $i++;
    ?>

    <a href="<?php e($photo['show_url']); ?>"><img src="<?php e(url('/file.php') . $photo['instance']['file_uri_parameters']); ?>" width="<?php e($photo['instance']['width']); ?>" height="<?php e($photo['instance']['height']); ?>" alt="" /></a>
<?php endforeach; ?>
</div>
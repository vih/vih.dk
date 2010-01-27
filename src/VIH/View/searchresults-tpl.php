<h1><?php echo $headline; ?></h1>

<?php echo $form; ?>

<?php if (!empty($results)): ?>
    <?php if ($results->numResults() > 0): ?>

    <h2><?php echo $results_headline; ?></h2>

    <p class="results"><?php if (!empty($results_count)) echo $results_count; ?></p>

    <dl id="search_results">
        <?php foreach ($results as $key => $result): if (!is_object($result)) continue; ?>
          <dt><a href="<?php echo $result->URL; ?>"><?php echo utf8_decode($result->title); ?></a></dt>
          <dd><?php echo rtrim(utf8_decode($result->snippet)); ?></dd>
        <?php endforeach; ?>
    </dl>

    <p class="nav"><?php if (!empty($page_nav)) echo $page_nav; ?></p>
    <?php else: ?>
    <p>Der er ikke nogen søgeresultater. Prøv igen!</p>
    <?php endif; ?>
<?php endif; ?>
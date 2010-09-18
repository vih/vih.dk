<html>
	<head>
		<title><?php e($title); ?></title>
		<meta http-equiv="content-type" content="text/html; charset=<?php e($encoding); ?>" />
		<style type="text/css">
			@import "<?php e(url("style.css")); ?>";
		</style>

	</head>

	<body>
		<div id="container">
            <?php if (!empty($this->document->navigation)): ?>
			<p id="logout">
                <?php foreach ($this->document->navigation as $url => $name): ?>
                    <a href="<?php e($url); ?>"><?php e($name); ?></a>
                <?php endforeach; ?>
            </p>
            <?php endif; ?>

			<div id="content">
				<?php echo $content; ?>
			</div>

			<p style="clear: both;" />&nbsp;</p>

		</div>

	</body>

</html>
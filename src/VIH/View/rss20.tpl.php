<?php
	echo '<?xml version="1.0" encoding="iso-8859-1"?>';
	echo "\n";
	echo '<?xml-stylesheet href="/css/rss.css" type="text/css"?>';
	echo "\n";
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<title><?php echo $title; ?></title>
		<link><?php echo $link; ?></link>
		<language><?php echo $language; ?></language>
		<description><?php echo $description; ?></description>
		<docs><?php echo $docs; ?></docs>

		<?php if (is_array($items)): ?>

		<?php foreach ($items AS $item): ?>
		<item>
			<title><?php echo $item['title']; ?></title>
			<description><?php echo $item['description']; ?></description>
			<pubDate><?php echo $item['pubDate']; ?></pubDate>
			<author><?php echo $item['author']; ?></author>
			<link><?php echo $item['link']; ?></link>
			<?php
			/*
			Skulle nok lave understøttelse for flere kategorier
			*/
			?>
			<category><?php if (!empty($item['category'])) echo $item['category']; ?></category>
		</item>
		<?php endforeach; ?>

		<?php endif; ?>
	</channel>
</rss>

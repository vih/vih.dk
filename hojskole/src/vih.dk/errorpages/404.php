<?php
/**
 * 404
 *
 * Husk at sætte header. Siden må ikke indeholde noget, der ellers kan opstå
 * fejl i.
 *
 * http://www.alistapart.com/articles/perfect404/
 */
header("HTTP/1.0 404 Not Found");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
	<head>
		<title>404 // Ikke fundet</title>
		<style type="text/css">
			body {
				text-align: center;
				font-family: "trebuchet ms", arial, sans-serif;
			}
			#container {
				text-align: left;
				width: 70%;
				margin: auto;
				border: 8px solid #d1aad1;
				padding: 2em;
			}
		</style>

	</head>
	
	<body>

		<div id="container">
			<h1>404 // Ikke fundet</h1>
			<p>Undskyld, vi har ledt dig på vildspor. Vi har ledt over alt; i alle gemmesteder og på alle de støvede harddiske, men vi har ikke fundet det, du leder efter. Det er garanteret, fordi vi har flyttet siden og glemt at aflevere adresseændringen. Det undskylder vi - og vi håber, at du alligevel vil bruge lidt tid på Vejle Idrætshøjskoles side.</p>
			<hr />
			<p>Du kan måske komme på rette spor ved at prøve følgende:</p>
			<ul>
				<li>Spring til <a href="/">Vejle Idrætshøjskoles startside</a>.</li>
				<li>Gå på udkig efter siden i vores <a href="/om/sitemap.php">sitemap</a>.</li>
				<li>Lad vores <a href="/search.php">søgemaskine</a> kigge vores sider igennem for dig.</li>
				<li>Gå <a href="#" onclick="history.back(1); return false;">tilbage</a> til den side du kom fra.</li>
			</ul>
			<p>Vi har orienteret vores webmaster om, at han har dummet sig. Han har lovet, at han vil gøre alt, hvad han kan, for at det ikke sker igen. Men på den anden side: Det sagde han også sidste gang.</p>
			<hr />
			<h5>HTTP 404 - File not found<br>Internet Information Services</h5>
		</div>
	</body>
</html>

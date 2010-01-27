<?php
/**
 * 404
 *
 * Husk at s�tte header. Siden m� ikke indeholde noget, der ellers kan opst�
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
			<p>Undskyld, vi har ledt dig p� vildspor. Vi har ledt over alt; i alle gemmesteder og p� alle de st�vede harddiske, men vi har ikke fundet det, du leder efter. Det er garanteret, fordi vi har flyttet siden og glemt at aflevere adresse�ndringen. Det undskylder vi - og vi h�ber, at du alligevel vil bruge lidt tid p� Vejle Idr�tsh�jskoles side.</p>
			<hr />
			<p>Du kan m�ske komme p� rette spor ved at pr�ve f�lgende:</p>
			<ul>
				<li>Spring til <a href="/">Vejle Idr�tsh�jskoles startside</a>.</li>
				<li>G� p� udkig efter siden i vores <a href="/om/sitemap.php">sitemap</a>.</li>
				<li>Lad vores <a href="/search.php">s�gemaskine</a> kigge vores sider igennem for dig.</li>
				<li>G� <a href="#" onclick="history.back(1); return false;">tilbage</a> til den side du kom fra.</li>
			</ul>
			<p>Vi har orienteret vores webmaster om, at han har dummet sig. Han har lovet, at han vil g�re alt, hvad han kan, for at det ikke sker igen. Men p� den anden side: Det sagde han ogs� sidste gang.</p>
			<hr />
			<h5>HTTP 404 - File not found<br>Internet Information Services</h5>
		</div>
	</body>
</html>

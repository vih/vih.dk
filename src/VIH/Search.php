<?php
/**
 * Der bør være mulighed for at sortere menuer fra.
 *
 * @author Lars Olesen <lars@legestue.net>
 *
 */
class VIH_Search {

	var $ignore = array();

	function VIH_Search() {
	}

	function setIgnore($ignore) {
		if (!is_array($ignore)) {
			trigger_error('VIH_Search::setIgnore() kræver et array', E_WARNING);
		}
		$this->ignore = $ignore;
	}

	function indexSite() {
		$db = new DB_Sql;
		for($j = 0; $j < 5; $j=$j+1) {

			$db->query("SELECT * FROM search_link WHERE indexed = 0");
			while ($db->nextRecord()) {
				$req = & new HTTP_Request(
					$db->f('link'),
					array(
						'timeout', 3
					)
				);
				if (PEAR::isError($req->sendRequest())) {
					continue;
				}
				$html = $req->getResponseBody();

				#process html

				# hente title, meta

				# slette ignored

				# finde alle links
				preg_match_all('/href=\"(.*?)\"/si',$buffer,$matches);

				for ($i=0, $max = count($matches[0]); $i< $max; $i++) {
					$httpfil = $matches[1][$i];

					if( substr($httpfil,0,1)=="/" && substr($httpfil,-3)!="css" && (!strstr($httpfil,"#")) && (!strstr($httpfil,"?"))) { // fjerner uønskede links

						// tager kun filer som ender på php
						eregi("\.([a-z0-9]+)$", $httpfil, $extension);

						if ($extension[0] == '.php')  {

							$db->query("SELECT id FROM soeg_link WHERE link = '$httpfil'");

							if (!$db->next_record()) {
								$db->query("INSERT INTO soeg_link (link, fundet) VALUES('$httpfil', '$filnavn')");
							}
						}
					}
				}


			}

		}
	}

}
?>
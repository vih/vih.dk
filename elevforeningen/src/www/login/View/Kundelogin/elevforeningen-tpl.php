<div id="content-main">

	<h1>Medlem # <?php echo $medlem->get('id'); ?></h1>

	<p class="explanation">På denne side kan du ændre dine adresseoplysninger og tilmelde dig Elevstævnet.</p>

	<?php echo $medlemsoplysninger; ?>
	
</div>

<div id="content-sub">

	<p>
		Der bør være et link, hvor man kan slette sig selv fra Elevforeningens register - no questions asked.
	</p>
	
	<p>
		Hvis man har blog - link til blog hos FFD, ellers
		Reklame for blog hos FFD.
		http://www.hojskolerne.dk/opret-profil.aspx
	</p>

	<p id="call">
		Spørgsmål? &mdash; skriv til
		<?php echo antispambot('elevforeningen@vih.dk'); ?>
	</p>

</div>
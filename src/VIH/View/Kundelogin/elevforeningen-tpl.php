<div id="content-main">

	<h1>Medlem # <?php e($medlem->get('id')); ?></h1>

	<p class="explanation">P� denne side kan du �ndre dine adresseoplysninger og tilmelde dig Elevst�vnet.</p>

	<?php echo $medlemsoplysninger; ?>

</div>

<div id="content-sub">

	<p>
		Der b�r v�re et link, hvor man kan slette sig selv fra Elevforeningens register - no questions asked.
	</p>

	<p>
		Hvis man har blog - link til blog hos FFD, ellers
		Reklame for blog hos FFD.
		http://www.hojskolerne.dk/opret-profil.aspx
	</p>

	<p id="call">
		Sp�rgsm�l? &mdash; skriv til
		<?php echo antispambot('elevforeningen@vih.dk'); ?>
	</p>

</div>
<div id="content-main">
    <h1>Betaling</h1>
    <p>Tak fordi du bruger <span class="dankort">Dankort</span> til at betale for tilmelding #<?php e($tilmelding->get('id')); ?> til de <?php e($course_type); ?> kurser.</p>
    <?php if (!empty($extra_text)) echo $extra_text; ?>
    <?php if (!empty($error)) echo $error; ?>
    <?php echo $this->getForm()->toHTML(); ?>
</div>
<div id="content-sub">
    <h2>Sikkerhedsnummeret</h2>
    <p>Du finder sikkerhedsnummeret (cvd) bag p� Dankortet.</p>
    <p><img src="<?php e(url('/gfx/images/dankort_cifre.gif')); ?>" alt="Hvor er sikkerhedscifrene p� dankortet?" /></p>
    <h2>Sikkerhed</h2>
    <p>Du kan l�se mere om sikkerhed og <span class="dankort">Dankort</span> p� <a href="http://www.betaling.dk/">PBS</a>.</p>
    <p>Vores betalingsl�sning ligger p� en sikker server, og vi gemmer aldrig kortoplysninger i vores database.</p>
    <p>Hvis du har sp�rgsm�l, er du velkommen til at ringe til os p� telefon 7582 0811.</p>
</div>
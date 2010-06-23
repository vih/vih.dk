<?php if (is_object($tilmelding) AND !empty($login_uri)): ?>
    <p>Du kan betale med dankort eller kontooverførsel.</p>
    <h3>Dankort &mdash; betal online med det samme</h3>
    <p>Du kan betale online med <span class="dankort">Dankort</span> med det samme. <a id="onlinepayment" href="<?php e($login_uri); ?>">Betal online &rarr;</a></p>
    <h3>Betal i banken eller homebanking</h3>
    <p>Du kan betale ved at overføre penge til vores konto i Jyske Bank. Husk at opgive følgende oplysninger:</p>
    <ul>
        <li>Tilmeldingsnummer: <?php e($tilmelding->get('id')); ?></li>
        <li>Kontaktpersonens navn: <?php e($tilmelding->get('navn')); ?></li>
        <li>Kursus: <?php e($tilmelding->kursus->getKursusNavn()); ?></li>
    </ul>
    <p>Du overfører bare pengene til kontonummer <strong>7244-1469664</strong>.</p>

<?php else: ?>
    <p>Kan ikke vise betalingsinformationerne. Ring til skolen på 75820811, hvis du er i tvivl.</p>
<?php endif; ?>

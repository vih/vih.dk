<div id="registration-col1">

    <h1>Tilmelding #<?php e($tilmelding->get('id')); ?></h1>

    <p>På denne side kan du følge din tilmelding. En udskrift af siden fungerer som en kvittering.</p>

    <?php if (count($tilmelding->betaling->getList('not_approved')) > 0): ?>
        <p class="notice">Du har afventende betalinger på <?php e($tilmelding->get('betalt_not_approved')); ?> kroner. Betalingerne fremgår først af oversigten, når vi har hævet betalingen.</p>
    <?php elseif ($tilmelding->get('skyldig_depositum') > 0): ?>
        <p class="notice">Foreløbig har du reserveret en plads. Vi har endnu ikke registreret betaling af depositum. Hvis du har betalt inden for de seneste par dage, kan du se bort fra denne meddelelse. Hvis du endnu ikke har betalt, beder vi dig betale depositum inden <?php echo $tilmelding->getForfaldenDato('depositum', 'dk'); ?>. <a href="<?php e(url('onlinebetaling')); ?>">Betal <span class="dankort">online</span> &rarr;</a></p>
    <?php elseif ($tilmelding->get('saldo') > 0): ?>
        <p class="notice">Ifølge vores bogføring skylder du <?php e($tilmelding->get('skyldig')); ?> kroner. Hvis du har betalt inden for de seneste dage, kan du se bort fra denne meddelelse. Hvis du endnu ikke har betalt, beder vi dig betale senest <?php e($tilmelding->getForfaldenDato('', 'dk')); ?> - <a href="<?php e(url('onlinebetaling')); ?>">Betal online &rarr;</a></p>
    <?php endif; ?>

    <?php echo $oplysninger; ?>

    <?php echo $deltagere; ?>

</div>

<div id="registration-col2">

    <p id="status">
        <span>Status</span>
        <?php e(ucfirst($tilmelding->get('status'))); ?>
    </p>

    <?php echo $betalinger; ?>

    <?php if ($tilmelding->get('skyldig') > 0): ?>

        <p><a href="<?php e(url('onlinebetaling')); ?>">Betal <span class="dankort">online</span> &rarr;</a></p>

    <?php endif; ?>

    <p id="call">
        Spørgsmål? &mdash; ring på
        <span>75820811</span>
    </p>

</div>

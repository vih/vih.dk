<div id="registration-col1">

    <h1>Tilmelding #<?php e($tilmelding->get('id')); ?></h1>

    <p>På denne side kan du altid følge din tilmelding, betale skyldige beløb og udskrive kvitteringer.</p>

    <?php if (count($tilmelding->betalingsobject->getList('not_approved')) > 0): ?>
        <p id="notice">Du har afventende betalinger på <?php e($tilmelding->get('betalt_not_approved')); ?> kroner. Betalingerne fremgår først af oversigten, når vi har hævet betalingen.</p>
    <?php elseif ($tilmelding->get('skyldig_tilmeldingsgebyr') > 0): ?>
        <p id="notice">Du skal lige have betalt tilmeldingsgebyret på <?php e($tilmelding->get('skyldig_tilmeldingsgebyr')); ?> kroner. Hvis du har betalt inden for de seneste par dage, kan du se bort fra denne meddelelse - <a href="<?php echo url('onlinebetaling'); ?>">Betal <span class="dankort">online</span> &rarr;</a></p>
    <?php elseif ($tilmelding->get('saldo') > 0): ?>
        <p id="notice">Du skylder <?php e($tilmelding->get('skyldig')); ?> kroner, som du skal betale i nogle forskellige rater. Du kan se mere under <a href="<?php echo url('onlinebetaling'); ?>">onlinebetalingen &rarr;</a>. Vær opmærksom på, at der går nogle dage før vi modtager dem. Derfor skal du være tålmodig.</p>
    <?php endif; ?>

    <?php echo $oplysninger; ?>

    <h2>Fag</h2>
    <p><a href="<?php e(url('fag')); ?>">Rediger fag</a></p>
    <?php
        Doctrine_Manager::connection(DB_DSN);
        $registration = Doctrine::getTable('VIH_Model_Course_Registration')->findOneById($tilmelding->getId());
        foreach ($registration->Subjects as $subject) {
            // e($subject->getName());
        }
    ?>

</div>

<div id="registration-col2">

    <p id="status">
        <span>Status</span>
        <?php e(ucfirst($tilmelding->get('status'))); ?>
    </p>

    <?php echo $prisoversigt; ?>

    <?php echo $betalinger; ?>

    <?php if ($tilmelding->get('skyldig') > 0): ?>

        <p><a href="<?php e(url('onlinebetaling')); ?>">Betal <span class="dankort">online</span> &rarr;</a></p>

    <?php endif; ?>

    <p id="call">
        Spørgsmål? &mdash; ring på
        <span>75820811</span>
    </p>
</div>
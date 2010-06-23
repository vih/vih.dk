<h1>V�lg fag p� <?php e($tilmelding->getKursus()->getKursusNavn()); ?></h1>

<?php
    $chosen = array();
    $registration = Doctrine::getTable('VIH_Model_Course_Registration')->findOneById($tilmelding->getId());
    $ch_subj = Doctrine::getTable('VIH_Model_Course_Registration_Subject')->findByRegistrationId($tilmelding->getId());

    foreach ($ch_subj as $subj) {
    	$chosen[$subj->period_id . $subj->subject_id . $subj->subjectgroup_id] = $subj->subject_id;
    }
?>

<p>Inden du kommer p� skolen, skal du v�lge de fag, du har flest timer om ugen, mens du er p� skolen. Resten af fagene v�lger du, n�r du ankommer.</p>

<p class="notice"><strong>Husk:</strong> Du skal kun v�lge <strong>et</strong> fag i hver blok. Der tages forbehold for at fag ikke oprettes pga. for f� tilmeldte til faget. Dette f�r du besked om inden ankomst.</p>

<form action="<?php e(url()); ?>" method="post" id="fag">
<?php $i = 0; foreach ($periods as $p): ?>
    <h2 class="periode"><?php e($p->getName()); ?></h2>
    <?php $subjectgroups = Doctrine::getTable('VIH_Model_Course_SubjectGroup')->findByPeriodId($p->getId()); ?>
    <?php foreach ($subjectgroups as $grp): ?>
        <?php if (!$grp->isElectiveCourse()) continue; ?>
        <fieldset>
        <legend><?php e($grp->getName()); ?></legend>
        <?php foreach ($grp->Subjects as $subj): ?>
            <input type="checkbox" name="subject[<?php e($i); ?>]" value="<?php e($subj->getId()); ?>"<?php if ($chosen[$p->getId() . $subj->getId() . $grp->getId()] == $subj->getId()) echo ' checked="checked"' ?>>
            <input type="hidden" name="subjectperiod[<?php e($i); ?>]" value="<?php e($p->getId()); ?>" />
            <input type="hidden" name="subjectgroup[<?php e($i); ?>]" value="<?php e($grp->getId()); ?>" />
            <label for=""><?php e($subj->getName()); ?></label>
        <?php ++$i; ?>
        <?php endforeach; ?>
        </fieldset>
    <?php endforeach; ?>
<?php endforeach; ?>

<p><input type="submit" id="submit" value="Videre" /></p>
</form>
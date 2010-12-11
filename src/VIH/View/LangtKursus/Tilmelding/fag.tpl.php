<h1>Vælg fag på <?php e($tilmelding->getKursus()->getKursusNavn()); ?></h1>

<p>Inden du kommer på skolen, skal du vælge de fag, du har flest timer om ugen, mens du er på skolen. Resten af fagene vælger du, når du ankommer.</p>

<p class="notice"><strong>Husk:</strong> Du skal kun vælge <strong>et</strong> fag i hver blok. Der tages forbehold for at fag ikke oprettes pga. for få tilmeldte til faget. Dette får du besked om inden ankomst.</p>

<form action="<?php e(url()); ?>" method="post" id="fag">
<?php $i = 0; foreach ($periods as $p): ?>
    <h2 class="periode"><?php e($p->getName()); ?></h2>
    <?php $subjectgroups = Doctrine::getTable('VIH_Model_Course_SubjectGroup')->findByPeriodId($p->getId()); ?>
    <?php foreach ($subjectgroups as $grp): ?>
        <?php if (!$grp->isElectiveCourse()) continue; ?>
        <fieldset>
        <legend><?php e($grp->getName()); ?></legend>
        <?php foreach ($grp->Subjects as $subj): ?>
            <input type="checkbox" name="subject[<?php e($i); ?>]" value="<?php e($subj->getId()); ?>"<?php if (isset($chosen[$p->getId() . $subj->getId() . $grp->getId()]) AND $chosen[$p->getId() . $subj->getId() . $grp->getId()] == $subj->getId()) echo ' checked="checked"' ?>>
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
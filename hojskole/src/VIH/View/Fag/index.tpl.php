<h1>Linjer og specialer</h1>
<p>For os er idræt en måde at være sammen på og et middel til at opleve egne og andres muligheder. Idræt er personlighedsudviklende, men personlig udvikling er andet og mere end idræt, derfor lægger vi vægt på musiske, kreative og andre mere bløde fag.</p>
<p>På Vejle Idrætshøjskole får du en leder- og instruktøruddannelse i en af de syv idrætsgrene, men de fleste af vores elever, fremhæver ofte alle fagene omkring idrætten som deres primære udbytte.</p>

<h2>Sammensæt dit skema</h2>

<p>Du kan selv sammensætte dit skema fra fagene i den højre bjælke. Nedenunder har vi lavet fire eksempler på fagpakker, du kan få på Vejle Idrætshøjskole.</p>

<ul id="pakker">
<?php foreach ($packages as $package): ?>
    <li><a id="<?php e($package); ?>" href="<?php e(url('pakke/' . $package)); ?>"><span></span><strong><?php e(__($package)); ?></strong></a></li>
<?php endforeach; ?>
</ul>

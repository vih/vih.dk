<h1>Linjer og specialer</h1>
<p>For os er idr�t en m�de at v�re sammen p� og et middel til at opleve egne og andres muligheder. Idr�t er personlighedsudviklende, men personlig udvikling er andet og mere end idr�t, derfor l�gger vi v�gt p� musiske, kreative og andre mere bl�de fag.</p>
<p>P� Vejle Idr�tsh�jskole f�r du en leder- og instrukt�ruddannelse i en af de syv idr�tsgrene, men de fleste af vores elever, fremh�ver ofte alle fagene omkring idr�tten som deres prim�re udbytte.</p>

<h2>Sammens�t dit skema</h2>

<p>Du kan selv sammens�tte dit skema fra fagene i den h�jre bj�lke. Nedenunder har vi lavet fire eksempler p� fagpakker, du kan f� p� Vejle Idr�tsh�jskole.</p>

<ul id="pakker">
<?php foreach ($packages as $package): ?>
    <li><a id="<?php e($package); ?>" href="<?php e(url('pakke/' . $package)); ?>"><span></span><strong><?php e(t($package)); ?></strong></a></li>
<?php endforeach; ?>
</ul>

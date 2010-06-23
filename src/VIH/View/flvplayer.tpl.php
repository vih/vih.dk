<?php
if (empty($width)) $width  = 150;
if (empty($height)) $height = 120;
if (empty($preview)) $preview = '';
$id = uniqid();
?>
<div class="flashwrap5">
<p id="<?php e($id); ?>" class="flashplayer5">
    Du skal bruge Flash Player for at se denne film. Den kan hentes på <a href="http://www.macromedia.com/go/getflashplayer">macromedia.com</a>.
</p>

<script type="text/javascript">
    var s1 = new SWFObject("<?php e(url('/gfx/flash/flvplayer.swf')); ?>","single","<?php e($width); ?>","<?php e($height); ?>","7");
    s1.addParam("wmode", "transparent");
    s1.addParam("allowfullscreen","true");
    s1.addVariable("file","<?php e($url); ?>");
    s1.addVariable("displayheight","<?php e($height); ?>");
    s1.addVariable("image","<?php e($preview); ?>");
    s1.addVariable("width","<?php e($width); ?>");
    s1.addVariable("height","<?php e($height); ?>");
    s1.addVariable("showdigits","false");
    s1.addVariable("largecontrols","false");
    s1.write("<?php e($id); ?>");
</script>

<div class="tlc2"></div>
<div class="trc2"></div>
<div class="blc2"></div>
<div class="brc2"></div>
</div>
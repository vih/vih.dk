<div id="header">
    <div id="hd">
        <h1><a href="<?php e(url('/')); ?>"><span>Vejle Idr�tsh�jskole</span></a></h1>
    </div>
</div>
<div id="inner">
    <div id="main">
        <div class="content">
            <div class="sidepic clearfix"<?php echo $this->getSidePicture(); ?>>
                <div id="col1">
                    <ul id="navigation">
                        <?php foreach($navigation as $item): ?>
                            <li<?php if ($this->getSubspace() AND strstr($item['url'], $this->getSubspace())) echo ' id="current"'; ?>><a href="<?php e($item['url']); ?>"><?php e($item['navigation_name']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php echo $content; ?>
            </div>
        </div>
    </div>
    <div id="footer" class="clearfix">
        <div id="footer-inner">
            <ul id="navigation-sites">
                <li id="elevforeningen"><a href="http://vih.dk/elevforeningen">Elevforeningen</a></li>
                <li id="efterskolen"><a href="http://www.vies.dk/">Efterskolen</a></li>
                <li id="kursuscenteret"><a href="http://vih.dk/kursuscenter">Kursuscenter</a></li>
            </ul>
            <p id="address">
                �rnebjergvej 28<br>
                7100 Vejle<br>
                Telefon: 7582 0811<br>
                <a href="<?php e(url('/kontakt')); ?>">E-mail</a>
            </p>

            <p id="breadcrumb">
                Du er her:
                <?php foreach ($this->document->trail as $name => $href): ?>
                    <a href="<?php e($href); ?>"><?php e($name); ?></a> /
                <?php endforeach; ?>
                <?php e($this->document->title); ?>
            </p>
        </div>
    </div>
</div>

<div id="prop"></div>
<div id="prop2"></div>
<div id="base"></div>
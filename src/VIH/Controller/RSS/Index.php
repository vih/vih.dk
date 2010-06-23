<?php
class VIH_Controller_RSS_Index extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $this->document->setTitle('RSS-feeds');
        $meta['description'] = '';
        $meta['keywords'] = '';
        $this->document->meta = $meta;
        $data = array('content' => '
            <h1><acronym title="Rich Site Summary">RSS</acronym>-feed</h1>
            <p>Vi tilbyder en række RSS-feeds, så du let kan holde dig orienteret om opdateringer af vores side.</p>
            <h2>Hvad er en <acronym title="Rich Site Summary">RSS</acronym>-feed</h2>
            <p>RSS-feeds er en smart måde at sende tekst, der er platformsuafhængig ud på. RSS er en forkortelse for Rich Site Summary, hvilket ordret kan oversættes til fyldigt hjemmeside sammendrag.</p>
            <p>Et RSS-feed er, kort fortalt, en <acronym title="eXtensible Markup Language">XML</acronym>-fil vi stiller til rådighed for dig, så du via en RSS-reader kan holde dig opdateret med hvad der sker på Vejle Idrætshøjskole.</p>
            <h2>Hvordan læser jeg en RSS-feed</h2>
            <p>Du kan fx bruge <a href="http://www.feedreader.com/">Feedreader</a>, <a href="http://www.google.com/reader/">Google Reader</a> eller <a href="http://www.bloglines.com/">Bloglines</a> til at læse vores RSS-feeds.</p>
        ', 'content_sub' => '<h2>Vores RSS-feeds</h2>
            <ul>
                <li class="rss"><a href="'.$this->url('/nyheder.xml').'">Nyheder</a></li>
                <li class="rss"><a href="'.$this->url('/kortekurser.xml').'">Korte kurser</a></li>
                <li class="rss"><a href="'.$this->url('/langekurser.xml').'">Lange kurser</a></li>
            </ul>

            <p>Alle vores feeds validerer</p>
            <p><img src="'.$this->url('/gfx/icons/valid-rss.png').'" alt="RSS valideret" /></p>

            <p>Du kan selv validere vores feeds med <a href="http://feedvalidator.org/">Feedvalidator.org</a> eller med <a href="http://validator.w3.org/feed/">W3.org</a></p>');

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }
}
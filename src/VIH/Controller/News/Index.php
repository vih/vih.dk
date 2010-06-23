<?php
class VIH_Controller_News_Index extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function map($name)
    {
        return 'VIH_Controller_News_Show';
    }

    function renderHtml()
    {
        $title               = 'Nyheder';
        $meta['description'] = 'Her finder du de seneste nyheder fra Vejle Idrætshøjskole.';
        $meta['keywords']    = 'Vejle, Idrætsøjskole, nyheder, sidste, nyt';

        $this->document->setTitle($title);
        $this->document->addCrumb($this->name(), $this->url());
        $this->document->meta    = $meta;
        $this->document->feeds[] = array('title' => 'Nyheder',
                                       'link' => $this->url('/rss/nyheder'));

        $data = array('content' => '<h1>Nyheder</h1>
            <p class="rss-big">Du kan abonnere på vores nyheder gennem et <a href="'.$this->url('/rss/nyheder') . '">rss-feed</a>.  <a href="'.$this->url('/rss/').'">Hvad er det for noget?</a>.</p>
            ' . $this->getNewsList(),
                      'content_sub' => $this->getSubContent());
        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }

    function getNewsList()
    {
        $data = array('nyheder' => VIH_News::getList('', 100));
        $tpl = $this->template->create('News/nyheder');
        return $tpl->render($this, $data);
    }

    function getSubContent()
    {
        $content = '
        	<p>
        		<a href="http://www.facebook.com/pages/Vejle-Idraetshojskole/93365171887?ref=nf"><img src="'.$this->url('/gfx/icons/facebook_32.png').'">Facebook</a><br />
        		<a href="http://picasaweb.google.com/109563436763695883388"><img src="'.$this->url('/gfx/icons/picasa_32.png').'">Picasa</a><br />
        		<a href="http://www.youtube.com/user/vejleih"><img src="'.$this->url('/gfx/icons/youtube_32.png').'">Youtube</a><br />
        		<a href="http://twitter.com/vejleih"><img src="'.$this->url('/gfx/icons/twitter_32.png').'">Twitter</a><br />
        	</p>
        ';


        $data = array('headline' => 'Nyhedsbrev',
                      'text' => 'Du kan være sikker på at få de vigtigste nyheder, hvis du <a href="' . $this->url('/nyhedsbrev/') . '">tilmelder dig vores nyhedsbrev</a>.');

        $tpl = $this->template->create('spot');
        return $tpl->render($this, $data) .  $content;
    }

    function renderXml()
    {
        $news = VIH_News::getList('', 10, '');
        $i = 0;
        $items = array();
        foreach ($news AS $n):
            $items[$i]['title'] = strip_tags($n->get('overskrift'));
            $items[$i]['description'] = strip_tags($n->get('teaser'));
            $items[$i]['pubDate'] = $n->get('date_rfc822');
            $items[$i]['author'] = htmlspecialchars('Vejle Idrætshøjskole <kontor@vih.dk>');
            $items[$i]['link'] = 'http://vih.dk/nyheder/' . $n->get('id') . '/';
            $i++;
        endforeach;

        $data = array(
            'title' => 'Nyheder fra Vejle Idrætshøjskole',
            'link' => 'http://vih.dk/',
            'language' => 'da',
            'description' => 'De seneste nyheder fra Vejle Idrætshøjskole',
            'docs' => 'http://vih.dk/rss/',
            'items' => $items);

        $tpl = $this->template->create('rss20');
        return $tpl->render($this, $data);
    }
}

<?php
class VIH_Controller_News_Index extends k_Controller
{
    function forward($name)
    {
        $next = new VIH_Controller_News_Show($this, $name);
        return $next->handleRequest();
    }

    function GET()
    {
        $title               = 'Nyheder';
        $meta['description'] = 'Her finder du de seneste nyheder fra Vejle Idrætshøjskole.';
        $meta['keywords']    = 'Vejle, Idrætshøjskole, nyheder, sidste, nyt';

        $this->document->title   = $title;
        $this->document->meta    = $meta;
        $this->document->feeds[] = array('title' => 'Nyheder',
                                       'link' => $this->url('/rss/nyheder'));

        $data = array('content' => '<h1>Nyheder</h1>
            <p class="rss-big">Du kan abonnere på vores nyheder gennem et <a href="'.$this->url('/rss/nyheder') . '">rss-feed</a>.  <a href="'.$this->url('/rss/').'">Hvad er det for noget?</a>.</p>
            ' . $this->getNewsList(),
                      'content_sub' => $this->getSubContent());
        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);
    }

    function getNewsList()
    {
        $data = array('nyheder' => VIH_News::getList('', 100));
        return $this->render('VIH/View/News/nyheder-tpl.php', $data);
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

        return $this->render('VIH/View/spot-tpl.php', $data) . $content;
    }

    function handleRequest()
    {
        $this->document->trail[$this->name] = $this->url();
        return parent::handleRequest();
    }

}

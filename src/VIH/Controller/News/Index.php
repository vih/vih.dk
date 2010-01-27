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
        $pictures = VIH_News::getNewsPictures();
        $pic_html = '';
        if (is_array($pictures) AND count($pictures) > 0) {
            $pic_html = '<h2>De nyeste billeder</h2>';
            foreach($pictures AS $key=>$value) {
                $file = new VIH_FileHandler($value['file_id']);
                $file->loadInstance('filgallerithumb');
                $pic_html .= '<p><a href="'.$this->url('/nyheder/'.$value['nyhed_id']).'">'.$file->getImageHtml().'</a></p>';
            }
        }
        $data = array('headline' => 'Nyhedsbrev',
                      'text' => 'Du kan være sikker på at få de vigtigste nyheder, hvis du <a href="' . $this->url('/nyhedsbrev/') . '">tilmelder dig vores nyhedsbrev</a>.');

        return $this->render('VIH/View/spot-tpl.php', $data) . $pic_html;
    }

    function handleRequest()
    {
        $this->document->trail[$this->name] = $this->url();
        return parent::handleRequest();
    }

}

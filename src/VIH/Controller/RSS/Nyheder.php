<?php
class VIH_Controller_RSS_Nyheder extends k_Controller
{
    function GET()
    {
        $news = VIH_News::getList('', 10, '');
        $i = 0;
        $items = array();
        foreach ($news AS $n):
            $items[$i]['title'] = strip_tags($n->get('overskrift'));
            $items[$i]['description'] = strip_tags($n->get('teaser'));
            $items[$i]['pubDate'] = $n->get('date_rfc822');
            $items[$i]['author'] = htmlspecialchars('Vejle Idrætshøjskole <kontor@vih.dk>');
            $items[$i]['link'] = 'http://www.vih.dk/nyheder/' . $n->get('id') . '/';
            $i++;
        endforeach;

        $data = array(
            'title' => 'Nyheder fra Vejle Idrætshøjskole',
            'link' => 'http://www.vih.dk/',
            'language' => 'da',
            'description' => 'De seneste nyheder fra Vejle Idrætshøjskole',
            'docs' => 'http://www.vih.dk/rss/',
            'items' => $items);

        $data = $this->render('VIH/View/rss20-tpl.php', $data);

        $response = new k_http_Response(200, $data);
        $response->setEncoding(NULL);
        $response->setContentType('application/xml; charset=ISO-8859-1');
        $response->setHeader('Content-Length', strlen($data));
        $response->setHeader('Content-Transfer-Encoding', 'binary');
        $response->setHeader('Cache-Control', 'Public');
        $response->setHeader('Pragma', 'public');
        throw $response;
    }
}

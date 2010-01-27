<?php
class VIH_Controller_RSS_LangeKurser extends k_Controller
{
    function GET()
    {
        $kurser = VIH_Model_LangtKursus::getList('open');
        $i = 0;
        $items = array();
        foreach ($kurser AS $kursus):
            $items[$i]['title'] = $kursus->get('kursusnavn');
            $items[$i]['description'] = $kursus->get('description');
            $items[$i]['pubDate'] = $kursus->get('date_updated_rfc822');
            $items[$i]['author'] = htmlspecialchars('Vejle Idrætshøjskole <kontor@vih.dk>');
            $items[$i]['link'] = 'http://www.vih.dk/langekurser/' . $kursus->get('id') . '/';
            $i++;
        endforeach;

        $data = array(
            'title' => 'Lange kurser på Vejle Idrætshøjskole',
            'link' => 'http://www.vih.dk/',
            'language' => 'da',
            'description' => 'Kursusoversigten over lange kurser på Vejle Idrætshøjskole',
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
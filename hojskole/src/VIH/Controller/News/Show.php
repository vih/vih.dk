<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_News_Show extends k_Controller
{
    function GET()
    {
        $nyhed = new VIH_News($this->name);

        if (($nyhed->get('date_expire') < date('Y-m-d H:i:s') AND $nyhed->get('date_expire') != '0000-00-00 00:00:00') OR $nyhed->get('published') == 0 OR $nyhed->get('active') == 0) {
            throw new k_http_Header(404);
            exit;
        }

        $data = array('news' => $nyhed);

        $this->document->title = $nyhed->get('title');

        $data = array('content' => $this->render('VIH/View/News/nyhed-tpl.php', $data),
                      'content_sub' => $this->getSubContent());

        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);
    }

    function getSubContent()
    {
        $nyhed = new VIH_News($this->name);

        $pictures = $nyhed->getPictures();
        $pic_html = '';

        foreach ($pictures AS $pic) {
            $file = new VIH_FileHandler($pic['file_id']);
            if ($file->get('id')) {
                $file->loadInstance('filgallerithumb');
            } else {
                continue;
            }
            $pic_uri = $file->getImageHtml();
            $file->loadInstance('medium');
            $pic_html .= '<p><a href="'.htmlspecialchars($file->get('file_uri')).'" rel="lightbox">' . $pic_uri . '</a></p>';
        }

        return $pic_html;

    }
}
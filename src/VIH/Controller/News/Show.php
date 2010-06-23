<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_News_Show extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $nyhed = new VIH_News($this->name());

        if (($nyhed->get('date_expire') < date('Y-m-d H:i:s') AND $nyhed->get('date_expire') != '0000-00-00 00:00:00') OR $nyhed->get('published') == 0 OR $nyhed->get('active') == 0) {
            throw new k_PageNotFound();
            exit;
        }

        $data = array('news' => $nyhed);

        $this->document->setTitle($nyhed->get('title'));

        $tpl = $this->template->create('News/nyhed');

        $data = array('content' => $tpl->render($this, $data),
                      'content_sub' => $this->getSubContent());

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }

    function getSubContent()
    {
        $nyhed = new VIH_News($this->name());

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
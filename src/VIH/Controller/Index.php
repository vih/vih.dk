<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Index extends k_Component
{
    public $i18n = array(
        'January' => 'januar',
        'Februrary' => 'februar',
        'March' => 'marts',
        'May' => 'maj',
        'June' => 'juni',
        'July' => 'juli',
        'October' => 'oktober'
    );
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'En højskole for livet';
        $meta['description'] = 'Vejle Idrætshøjskole tilbyder forskellige højskolekurser. Vi er en højskole med idrætten som samlingspunkt.';
        $meta['keywords'] = 'jyske, idrætsskole, idrætshøjskoler, idrætshøjskole, højskole, højskoler, højskolekursus, højskolekurser, kursus, korte kurser, sommerkurser';

        $this->document->setTitle($title);
        $this->document->meta  = $meta;
        $this->document->rss   = array('title' => 'Nyheder',
                                       'link' => '/rss/nyheder.php');
        $this->document->body_class = 'sidepicture';

        if (date('m-d') > '12-01' AND date('m-d') < '12-24') {
            $this->document->body_class .= ' christmas';
        }

        $this->document->theme = 'frontpage';

        $packages = array('politi', 'fitness', 'outdoor', 'boldspil');

        $tpl = $this->template->create('frontpage');

        $data = array(
            'content' => $tpl->render($this, array('packages' => $packages)),
            'content_sub' => $this->getSubContent());

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);

    }

    function getSubContent()
    {
        $tpl = $this->template->create('News/sidebar-featured');

        $data = array('nyheder' => $tpl->render($this, array('nyheder' => VIH_News::getList('', 1, 'H�j'))),
                      'kurser' => VIH_Model_LangtKursus::getNext());

        $tpl = $this->template->create('frontpage-sidebar');
        return $tpl->render($this, $data);
    }
}
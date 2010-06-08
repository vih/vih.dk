<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Index extends k_Controller
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

    function GET()
    {
        $title = 'En h�jskole for livet';
        $meta['description'] = 'Vejle Idr�tsh�jskole tilbyder forskellige h�jskolekurser. Vi er en h�jskole med idr�tten som samlingspunkt.';
        $meta['keywords'] = 'jyske, idr�tsskole, idr�tsh�jskoler, idr�tsh�jskole, h�jskole, h�jskoler, h�jskolekursus, h�jskolekurser, kursus, korte kurser, sommerkurser';

        $this->document->title = $title;
        $this->document->meta  = $meta;
        $this->document->rss   = array('title' => 'Nyheder',
                                       'link' => '/rss/nyheder.php');
        $this->document->body_class = 'sidepicture';

        if (date('m-d') > '12-01' AND date('m-d') < '12-24') {
            $this->document->body_class .= ' christmas';
        }

        $this->document->theme = 'frontpage';

        $packages = array('politi', 'fitness', 'outdoor', 'boldspil');

        $data = array(
            'content' => $this->render('VIH/View/frontpage.tpl.php', array('packages' => $packages)),
            'content_sub' => $this->getSubContent());

        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);

    }

    function getSubContent()
    {
        $data = array('nyheder' => $this->render('VIH/View/News/sidebar-featured.tpl.php', array('nyheder' => VIH_News::getList('', 1, 'H�j'))),
                      'kurser' => VIH_Model_LangtKursus::getNext());

        return $this->render('VIH/View/frontpage-sidebar.tpl.php', $data);
    }

}
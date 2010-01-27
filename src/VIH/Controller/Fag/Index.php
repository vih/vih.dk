<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Fag_Index extends k_Controller
{
    function GET()
    {
        $title = 'Fagoversigt';
        $meta['description'] = 'Fagoversigt på Vejle Idrætshøjskole';
        $meta['keywords'] = 'Fagoversigt';

        $this->document->title = $title;
        $this->document->meta = $meta;
        $this->document->theme = 'fag';

        $data = array('packages' => array('politi', 'fitness', 'outdoor', 'boldspil'));

        $data = array('content' => $this->render('VIH/View/Fag/index.tpl.php', $data) . $this->getSkema(),
                      'content_sub' => $this->getSubContent());

        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);

    }

    function handleRequest()
    {
        $this->document->trail[$this->name] = $this->url();
        return parent::handleRequest();
    }

    function forward($name)
    {
        if ($name == 'pakke') {
        	$next = new VIH_Controller_Fag_Pakker_Index($this, $name);
        } else {
        	$next = new VIH_Controller_Fag_Show($this, $name);
        }

        return $next->handleRequest();
    }

    function getSubContent()
    {
        $fag = VIH_Model_Fag::getPublishedWithDescription();
        $data = array('fag' => $fag);

        return $this->render('VIH/View/Fag/faglist-tpl.php', $data);
    }

    function getSkema()
    {
        $skema = new VIH_Controller_LangtKursus_Skema($this);
        return $skema_html = $skema->execute();
    }

    function getWidePictureHTML($identifier)
    {
        $kernel = $this->registry->get('intraface:kernel');
        $translation = $kernel->getTranslation('filemanager');
        $filemanager = new Ilib_Filehandler_Manager($kernel);

        try {
            $img = new Ilib_Filehandler_ImageRandomizer($filemanager, array($identifier));
            $file = $img->getRandomImage();
        } catch (Exception $e) {
            return $this->url('/gfx/images/hojskole.jpg');
        }

        $instance = $file->createInstance('widepicture');
        $editor_img_uri = $instance->get('file_uri');
        $editor_img_height = $instance->get('height');
        $editor_img_width = $instance->get('width');

        return $this->url('/file.php') . $instance->get('file_uri_parameters');
    }
}
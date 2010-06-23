<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Fag_Index extends k_Component
{
    protected $template;
    protected $kernel;

    function __construct(k_TemplateFactory $template, VIH_Intraface_Kernel $kernel)
    {
        $this->template = $template;
        $this->kernel = $kernel;
    }

    function renderHtml()
    {
        $title = 'Fagoversigt';
        $meta['description'] = 'Fagoversigt p� Vejle Idr�tsh�jskole';
        $meta['keywords'] = 'Fagoversigt';

        $this->document->setTitle($title);
        $this->document->addCrumb($this->name(), $this->url());
        $this->document->meta = $meta;
        $this->document->theme = 'fag';

        $data = array('packages' => array('politi', 'fitness', 'outdoor', 'boldspil'));

        $tpl = $this->template->create('Fag/index');
        $data = array('content' => $tpl->render($this, $data) . $this->getSkema(),
                      'content_sub' => $this->getSubContent());

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }

    function map($name)
    {
        if ($name == 'pakke') {
        	return 'VIH_Controller_Fag_Pakker_Index';
        } else {
        	return 'VIH_Controller_Fag_Show';
        }
    }

    function getSubContent()
    {
        $fag = VIH_Model_Fag::getPublishedWithDescription();
        $data = array('fag' => $fag);

        $tpl = $this->template->create('Fag/faglist');
        return $tpl->render($this, $data);
    }

    function getSkema()
    {
        $skema = $this->createComponent('VIH_Controller_LangtKursus_Skema', '');
        return $skema->renderHtml();
    }

    function getWidePictureHTML($identifier)
    {
        $filemanager = new Ilib_Filehandler_Manager($this->kernel);

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
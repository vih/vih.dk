<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_LangtKursus_Rejser extends k_Component
{
    protected $template;
    protected $mdb2;
    protected $kernel;

    function __construct(k_TemplateFactory $template, MDB2_Driver_Common $mdb2, VIH_Intraface_Kernel $kernel)
    {
        $this->template = $template;
        $this->mdb2 = $mdb2;
        $this->kernel = $kernel;
    }

    function GET()
    {
        $result = $this->mdb2->query('SELECT * FROM langtkursus_fag WHERE fag_gruppe_id = 4 ORDER BY id'); // 4 er rejser

        $tpl = $this->template->create('LangtKursus/rejser');
        $content = $tpl->render($this, array('rejser' => $result));

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, array('content' => $content));
    }

    function getPictureHTML($identifier)
    {
        $filemanager = new Ilib_Filehandler_Manager($this->kernel);

        try {
            $img = new Ilib_Filehandler_ImageRandomizer($filemanager, array($identifier));
            $file = $img->getRandomImage();
        } catch (Exception $e) {
            return $this->url('/gfx/images/hojskole.jpg');
        }

        $instance = $file->createInstance('small');
        $editor_img_uri = $instance->get('file_uri');
        $height = $editor_img_height = $instance->get('height');
        $width = $editor_img_width = $instance->get('width');

        return '<img src="' . $this->url('/file.php') . $instance->get('file_uri_parameters') . '" width="'.$width.'" height="'.$height.'" />';
    }
}
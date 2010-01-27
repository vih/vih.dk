<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_LangtKursus_Rejser extends k_Controller
{
    function GET()
    {
        $conn = $this->registry->get('database:mdb2');
        $result = $conn->query('SELECT * FROM langtkursus_fag WHERE fag_gruppe_id = 4 ORDER BY id'); // 4 er rejser

        $content = $this->render('VIH/View/LangtKursus/rejser.tpl.php', array('rejser' => $result));

        return $this->render('VIH/View/sidebar-wrapper.tpl.php', array('content' => $content));
    }

    function getPictureHTML($identifier)
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

        $instance = $file->createInstance('small');
        $editor_img_uri = $instance->get('file_uri');
        $height = $editor_img_height = $instance->get('height');
        $width = $editor_img_width = $instance->get('width');

        return '<img src="' . $this->url('/file.php') . $instance->get('file_uri_parameters') . '" width="'.$width.'" height="'.$height.'" />';
    }
}
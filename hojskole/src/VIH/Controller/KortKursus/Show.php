<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_KortKursus_Show extends k_Controller
{
    function GET()
    {
        $kursus = new VIH_Model_KortKursus($this->name);
        $kursus->getPladser();
        $kursus->getBegyndere();

        if (!$kursus->get('kursusnavn') OR $kursus->get('dato_slut') < date('Y-m-d') OR $kursus->get('published') == 0) {
            throw new k_http_Response(404);
        }

        $underviser = new VIH_Model_Ansat($kursus->get('ansat_id'));

        $file = new VIH_FileHandler($kursus->get('pic_id'));
        $pic_html = '';
        if ($file->get('id') > 0) {
            $file->loadInstance('small');
            $image_tag = $file->getImageHtml();
            $file->loadInstance(IMAGE_POPUP_SIZE);
            $pic_html = '<a href="'.htmlspecialchars($file->get('file_uri')).'" rel="lightbox">' .$image_tag . '</a>';
        }

        $this->document->theme = $kursus->getGruppe();
        $this->document->title = $kursus->get('title');
        $this->document->meta = array('keywords' => $kursus->get('keywords'),
                                      'description' => $kursus->get('description'));
        $this->document->body_class = 'widepicture';
        $this->document->widepicture = $this->context->getWidePictureUrl($this->document->theme);
        $data = array('kursus' => $kursus,
                      'kursusleder' => new VIH_Model_Ansat($kursus->get('ansat_id')));

        $content = array('content' =>  $this->render('VIH/View/KortKursus/kursus-tpl.php', $data));

        return $this->render('VIH/View/wrapper-tpl.php', $content);
    }

    function forward($name)
    {
        if ($name == 'tilmelding') {
            $next = new VIH_Controller_KortKursus_Tilmelding_Index($this, $name);
            return $next->handleRequest();
        } else {
            $next = new VIH_Controller_KortKursus_Tilmelding_Venteliste($this, $name);
            return $next->handleRequest();
        }
    }
}
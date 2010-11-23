<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_KortKursus_Show extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function map($name)
    {
        if ($name == 'tilmelding') {
            return 'VIH_Controller_KortKursus_Tilmelding_Index';
        } else {
            return 'VIH_Controller_KortKursus_Tilmelding_Venteliste';
        }
    }

    function dispatch()
    {
        $kursus = $this->context->getGateway()->findById($this->name());
        if (!$kursus->get('kursusnavn') OR $kursus->get('dato_slut') < date('Y-m-d') OR $kursus->get('published') == 0) {
            throw new k_PageNotFound();
        }

        return parent::dispatch();
    }

    function renderHtml()
    {
        $kursus = $this->context->getGateway()->findById($this->name());
        $kursus->getPladser();
        $kursus->getBegyndere();

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
        $this->document->setTitle($kursus->get('title'));
        $this->document->meta = array('keywords' => $kursus->get('keywords'),
                                      'description' => $kursus->get('description'));
        $this->document->body_class = 'widepicture';
        $this->document->widepicture = $this->context->getWidePictureUrl($this->document->theme);
        $data = array('kursus' => $kursus,
                      'kursusleder' => new VIH_Model_Ansat($kursus->get('ansat_id')));

        $tpl = $this->template->create('KortKursus/kursus');
        $content = array('content' =>  $tpl->render($this, $data));

        $tpl = $this->template->create('wrapper');
        return $tpl->render($this, $content);
    }

}
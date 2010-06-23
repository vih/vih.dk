<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Ansat_Index extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'L�rerkr�fter';
        $meta['description'] = 'L�rerteamet p� Vejle Idr�tsh�jskole er et st�rkt team';
        $meta['keywords'] = 'vejle, idr�tsh�jskole, l�rere, undervisere, e-mail, e-post, email, epost, kontakt';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';
        $this->document->theme = 'underviser';
        $this->document->widepicture = $this->url('/gfx/images/hojskole.jpg');

        $data = array('content' => '
            <h1>Holdning til sig selv og sin sport</h1>
            <p>En skole bliver aldrig bedre end de l�rerkr�fter, der dagligt skal sikre en inspirerende og udviklende undervisning. Vi er derfor meget bevidste om, at vi skal kunne tiltr�kke og fastholde nogle af de dygtigste kapaciteter p� de forskellige fagomr�der. Men det er ikke tilstr�kkeligt kun med faglige kompetencer. Vejle Idr�tsh�jskoles slutprodukt er personlig udvikling, og derfor skal de menneskelige kompetencer ogs� v�re i top. Vi er et l�rekollegium, der skal dele m�ls�tning, og det b�de indenfor og udenfor banen. For kun herved kan vi fastholde vores position som en af Danmarks f�rende idr�tsh�jskoler.</p>',
                      'content_sub' => '<h2>L�r vores l�rerteam n�rmere at kende:</h2>' . $this->getTeacherList());

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }

    function getTeacherList()
    {
        $data = array('undervisere' => VIH_Model_Ansat::getList('l�rere'));
        $tpl = $this->template->create('Ansat/undervisere');
        return $tpl->render($this, $data);
    }

    function map($name)
    {
        return 'VIH_Controller_Ansat_Show';
    }
}
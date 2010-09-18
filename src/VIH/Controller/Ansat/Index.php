<?php
class VIH_Controller_Ansat_Index extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template, DB_Sql $db)
    {
        $this->template = $template;
        $this->db_sql = $db;
    }

    function map($name)
    {
        return 'VIH_Controller_Ansat_Show';
    }

    function renderHtml()
    {
        $title = 'Lærerkræfter';
        $meta['description'] = 'Lærerteamet på Vejle Idrætshøjskole er et stærkt team';
        $meta['keywords'] = 'vejle, idrætshøjskole, lærere, undervisere, e-mail, e-post, email, epost, kontakt';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';
        $this->document->theme = 'underviser';
        $this->document->widepicture = $this->url('/gfx/images/hojskole.jpg');

        $data = array('content' => '
            <h1>Holdning til sig selv og sin sport</h1>
            <p>En skole bliver aldrig bedre end de lærerkræfter, der dagligt skal sikre en inspirerende og udviklende undervisning. Vi er derfor meget bevidste om, at vi skal kunne tiltrække og fastholde nogle af de dygtigste kapaciteter på de forskellige fagområder. Men det er ikke tilstrækkeligt kun med faglige kompetencer. Vejle Idrætshøjskoles slutprodukt er personlig udvikling, og derfor skal de menneskelige kompetencer også være i top. Vi er et lærekollegium, der skal dele målsætning, og det både indenfor og udenfor banen. For kun herved kan vi fastholde vores position som en af Danmarks førende idrætshøjskoler.</p>',
                      'content_sub' => '<h2>Lær vores lærerteam nærmere at kende:</h2>' . $this->getTeacherList());

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }

    function getTeacherList()
    {
        $data = array('undervisere' => VIH_Model_Ansat::getList('lærere'));
        $tpl = $this->template->create('Ansat/undervisere');
        return $tpl->render($this, $data);
    }

    function getGateway()
    {
        return new VIH_Model_AnsatGateway($this->db_sql);
    }
}
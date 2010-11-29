<?php
class VIH_Controller_Login_Root extends k_Component
{
    protected $map = array(
        'langekurser' => 'VIH_Controller_LangtKursus_Login_Index',
        'kortekurser' => 'VIH_Controller_KortKursus_Login_Index'
    );

    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function map($name)
    {
        return $this->map[$name];
    }

    function wrapHtml($content)
    {
        $navigation = array(
            $this->url('/') => 'Oversigt',
            $this->url('/help') => 'Hjælp',
            $this->url('/logout') => 'Logout'
        );
        $tpl = $this->template->create('Kundelogin/main');
        return $tpl->render($this, array('navigation' => $navigation, 'content' => $content, 'title' => $this->document->title()));
    }
}
<?php
class VIH_Controller_Login_Root extends k_Component
{
    public $map = array(
        'langekurser' => 'VIH_Controller_LangtKursus_Login_Index',
        'kortekurser' => 'VIH_Controller_KortKursus_Login_Index'
    );

    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function wrapHtml($content)
    {
        $navigation = array(
            $this->url('/') => 'Oversigt',
            $this->url('/help') => 'Hjælp',
            $this->url('/logout') => 'Logout'
        );
        $tpl = $this->template->create('Kundelogin/main');
        return $tpl->render($this, array('navigation' => $navigation));
    }
}
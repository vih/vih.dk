<?php
class VIH_Controller_Login_Root extends k_Dispatcher
{
    public $map = array(
        'langekurser' => 'VIH_Controller_LangtKursus_Login_Index',
        'kortekurser' => 'VIH_Controller_KortKursus_Login_Index'
    );

    function __construct()
    {
        parent::__construct();
        $this->document->template = 'VIH/View/Kundelogin/main-tpl.php';
        $this->document->_navigation = array(
            $this->url('/') => 'Oversigt',
            $this->url('/help') => 'Hj�lp',
            $this->url('/logout') => 'Logout'
        );
    }

}
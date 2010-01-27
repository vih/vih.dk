<?php
class VIH_Intraface_Setting 
{
    /**
     * @var settings
     */
    private $settings = array(
        'user' => array('rows_pr_page' => 20)
    );

    public function get($level, $key) 
    {
        return $this->settings[$level][$key];
    }
}

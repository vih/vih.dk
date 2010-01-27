<?php
class VIH_Intraface_User 
{
    public function get($key) 
    {
        $values = array('id' => 1);
        return $values[$key];
    }

    public function hasModuleAccess() 
    {
        return true;
    }
    
    function getActiveIntranetId()
    {
        return 0;
    }
}



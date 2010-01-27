<?php
class VIH_Controller_LangtKursus_Tilmelding_Index extends k_Controller
{
    function GET()
    {
        $session_id = md5($this->SESSION->getSessionId());
        throw new k_http_Redirect($this->url($session_id));
    }

    function forward($name)
    {
        $next = new VIH_Controller_LangtKursus_Tilmelding_Kontakt($this, $name);
        $data = array('content' => $next->handleRequest());
        return $this->render('VIH/View/wrapper-tpl.php', $data);
    }

    function getLangtKursusId()
    {
        return $this->context->name;
    }
    
    function getSubjects()
    {
        return $this->context->getSubjects();
    }
}
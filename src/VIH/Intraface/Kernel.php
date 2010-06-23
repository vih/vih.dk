<?php
class VIH_Translation
{
	function get($phrase)
    {
    	return $phrase;
    }
}

class VIH_Intraface_Kernel {

    private $translation;
    public $setting;
    public $intranet;
    public $user;
    public $sesion_id;

    public function __construct()
    {
        if (!session_id()) {
            session_start();
        }
        $this->session_id = session_id();
    }

    /**
     * We should actually return an object, but lets see how this works
     */
    public function module($module) {}

    public function useShared($shared) {}

    public function getTranslation($page_id)
    {
        return new VIH_Translation;
    }

    public function getSessionId()
    {
        return $this->session_id;
    }

    function randomKey()
    {
        return uniqid();
    }
}
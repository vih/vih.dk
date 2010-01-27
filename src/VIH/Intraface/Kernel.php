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
    public function module($module) {
    }

    public function useShared($shared)
    {
    }

    public function getTranslation($page_id)
    {
        return new VIH_Translation;
        /*
        $dbinfo = array(
            'hostspec' => DB_HOST,
            'database' => DB_NAME,
            'phptype'  => 'mysql',
            'username' => DB_USER,
            'password' => DB_PASSWORD
        );

        if (!defined('LANGUAGE_TABLE_PREFIX')) {
            define('LANGUAGE_TABLE_PREFIX', 'core_translation_');
        }

        $params = array(
            'langs_avail_table' => LANGUAGE_TABLE_PREFIX.'langs',
            'strings_default_table' => LANGUAGE_TABLE_PREFIX.'i18n'
        );

        require_once 'Translation2.php';

        $translation = Translation2::factory('MDB2', $dbinfo, $params);
        //always check for errors. In this examples, error checking is omitted
        //to make the example concise.
        if (PEAR::isError($translation)) {
            trigger_error('Could not start Translation ' . $translation->getMessage(), E_USER_ERROR);
        }

        // set primary language
        $set_language = $translation->setLang('dk');
        if (PEAR::isError($set_language)) {
            trigger_error($set_language->getMessage(), E_USER_ERROR);
        }

        // set the group of strings you want to fetch from
        // $translation->setPageID($page_id);

        // add a Lang decorator to provide a fallback language
        $translation = $translation->getDecorator('Lang');
        $translation->setOption('fallbackLang', 'uk');
        // $translation = $translation->getDecorator('LogMissingTranslation');
        // require_once("ErrorHandler/Observer/File.php");
        // $translation->setOption('logger', array(new ErrorHandler_Observer_File(ERROR_LOG), 'update'));
        $translation = $translation->getDecorator('DefaultText');

        return $translation;
        */
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
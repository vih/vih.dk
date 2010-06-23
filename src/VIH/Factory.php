<?php
class VIH_Factory
{
    function new_k_TemplateFactory($c)
    {
        return new k_DefaultTemplateFactory(dirname(__FILE__) . '/View/');
    }

    function new_IntrafacePublic_Newsletter_XMLRPC_Client()
    {
        $credentials = array("private_key" => INTRAFACE_PRIVATE_KEY,
                            "session_id"  => uniqid());
        XML_RPC2_Backend::setBackend("php");
        return new IntrafacePublic_Newsletter_XMLRPC_Client($credentials);
    }

    function new_pdoext_Connection()
    {
        return new pdoext_Connection("mysql:dbname=" . DB_NAME . ";host=" . DB_HOST, DB_USER, DB_PASSWORD);
    }

    function new_MDB2_Driver_Common()
    {
        $options= array("debug" => 2);
        $db = MDB2::factory(DB_DSN, $options);
        if (PEAR::isError($db)) {
            throw new Exception($db->getMessage());
        }
        $db->setOption("portability", MDB2_PORTABILITY_NONE);
        $db->setFetchMode(MDB2_FETCHMODE_ASSOC);
        $db->exec("SET time_zone=\"-01:00\"");
        return $db;
    }

    function new_Doctrine_Connection_Common()
    {
        $conn = Doctrine_Manager::connection(DB_DSN);
        Doctrine_Manager::getInstance()->setAttribute("model_loading", "conservative");
        return $conn;
    }

    function new_VIH_Intraface_Kernel()
    {
        $kernel = new VIH_Intraface_Kernel;
        $kernel->setting = new VIH_Intraface_Setting;
        $kernel->intranet = new VIH_Intraface_Intranet;
        $kernel->user = new VIH_Intraface_User;
        return $kernel;
    }
}
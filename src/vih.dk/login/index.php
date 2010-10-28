<?php
require_once 'config.local.php';
require_once 'VIH/ExceptionHandler.php';
require_once 'VIH/Logger.php';
require_once 'VIH/functions.php';
require_once 'VIH/configuration.php';
require_once 'konstrukt/konstrukt.inc.php';
require_once 'bucket.inc.php';
require_once 'Ilib/ClassLoader.php';
require_once 'Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));

class VIH_NotFoundComponent extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function dispatch()
    {
        $tpl = $this->template->create('404');
        $response = new k_HttpResponse(404, $tpl->render($this));
        return $response;
    }
}

class VIH_Document extends k_Document
{

}

$factory = new VIH_Factory();
$container = new bucket_Container($factory);

if (realpath($_SERVER['SCRIPT_FILENAME']) == __FILE__) {
    $components = new k_InjectorAdapter($container, new VIH_Document);
    $components->setImplementation('k_DefaultPageNotFoundComponent', 'VIH_NotFoundComponent');
    k()
    ->setComponentCreator($components)
    //->setLanguageLoader(new MyLanguageLoader())->setTranslatorLoader(new SimpleTranslatorLoader())
    ->run('VIH_Controller_Login_Root')
    ->out();
}
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

class VIH_Document extends k_Document
{
    public $meta = array();
    public $theme;
    public $rss = array();
    public $body_class;
    public $body_id;
    public $widepicture;
    public $sidepicture;
    public $trail = array();
    public $protocol;

    function addCrumb($name, $url)
    {
        $this->trail[$name] = $url;
    }
}

class EnglishLanguage implements k_Language
{
    function name()
    {
        return 'English';
    }

    function isoCode()
    {
        return 'en';
    }
}

class SwedishLanguage implements k_Language
{
    function name()
    {
        return 'Swedish';
    }

    function isoCode()
    {
        return 'sv';
    }
}

class MyLanguageLoader implements k_LanguageLoader
{
    function load(k_Context $context)
    {
        if ($context->query('lang') == 'sv') {
            return new SwedishLanguage();
        } else if ($context->query('lang') == 'en') {
            return new EnglishLanguage();
        }
        return new EnglishLanguage();
    }
}

class SimpleTranslator implements k_Translator
{
    protected $phrases;

    function __construct($phrases = array())
    {
        $this->phrases = $phrases;
    }

    function translate($phrase, k_Language $language = null)
    {
        return isset($this->phrases[$phrase]) ? $this->phrases[$phrase] : $phrase;
    }
}

class SimpleTranslatorLoader implements k_TranslatorLoader
{
    function load(k_Context $context)
    {
        // Default to English
        $phrases = array(
            'Hello' => 'Hello',
            'Meatballs' => 'Meatballs',
        );
        if ($context->language()->isoCode() == 'sv') {
            $phrases = array(
                'Hello' => 'Bork, bork, bork!',
                'Meatballs' => 'Swedish meatballs',
            );
        }
        return new SimpleTranslator($phrases);
    }
}

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
        $response = new k_HtmlResponse($tpl->render($this));
        $response->setStatus(404);
        return $response;
    }
}

$factory = new VIH_Factory();
$container = new bucket_Container($factory);
$mdb2 = $container->get('mdb2_driver_common');

if (realpath($_SERVER['SCRIPT_FILENAME']) == __FILE__) {
    $components = new k_InjectorAdapter($container, new VIH_Document);
    $components->setImplementation('k_DefaultPageNotFoundComponent', 'VIH_NotFoundComponent');
    k()
    ->setComponentCreator($components)
    ->setLanguageLoader(new MyLanguageLoader())->setTranslatorLoader(new SimpleTranslatorLoader())
    ->run('VIH_Controller_Root')
    ->out();
}

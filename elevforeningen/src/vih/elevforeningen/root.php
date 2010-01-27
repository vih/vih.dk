<?php
class VIH_Elevforeningen_Root extends k_Dispatcher
{
    public $debug = true;
    public $map = array('cms'        => 'IntrafacePublic_CMS_Controller_Index',
                        'stylesheet' => 'VIH_Elevforeningen_Stylesheet');

    function __construct()
    {
        parent::__construct();
        $this->document->template = dirname(__FILE__) . '/templates/main.tpl.php';
        $this->document->title = 'Vejle Idrætshøjskoles Elevforening';
        $this->document->styles[] = $this->url('/style.css');
        $this->document->navigation_section = array(
            array('url' => 'http://vih.dk/', 'navigation_name' => 'Vejle Idrætshøjskole')
        );
    }

    function execute()
    {
        throw new k_http_Redirect($this->url('cms'));
    }

    function handleRequest()
    {
        if ($this->context->getSubspace() == 'stylesheet') {
            $next = new VIH_Elevforeningen_Stylesheet($this);
            return $next->handleRequest();
        }

        $this->subspace = $this->context->getSubspace();
        $next = new IntrafacePublic_CMS_Controller_Index($this);

        return $this->render($this->document->template, Array(
            'content' => $next->handleRequest(),
            'encoding' => $this->document->encoding,
            'title' => $this->document->title,
            'scripts' => $this->document->scripts,
            'styles' => $this->document->styles,
            ));
    }
}

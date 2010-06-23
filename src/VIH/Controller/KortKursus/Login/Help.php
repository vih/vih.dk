<?php
class VIH_Controller_KortKursus_Login_Help extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $tilmelding = VIH_Model_KortKursus_Tilmelding::factory($usr->getProperty('handle'));
        $tilmelding->loadBetaling();

        $data = array('login_uri' => KORTEKURSER_LOGIN_URI,
                      'tilmelding' => $tilmelding);

        $this->document->setTitle('Tilmelding #' . $tilmelding->get('id'));

        $tpl = $this->template->create('Tilmelding/betaling');
        return '
            <h1>Hj�lp</h1>
            ' . $tpl->render($this);
    }
}


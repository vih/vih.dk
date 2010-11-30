<?php
class VIH_Controller_LangtKursus_Login_Tilmelding extends k_Component
{
    public $map = array(
        'onlinebetaling' => 'VIH_Controller_LangtKursus_Login_OnlineBetaling',
        'fag'            => 'VIH_Controller_LangtKursus_Login_Fag'
    );
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function map($name)
    {
        return $this->map[$name];
    }

    function dispatch()
    {
        $tilmelding = VIH_Model_LangtKursus_Tilmelding::factory($this->name());
        if (!is_object($tilmelding) OR !$tilmelding->get('id')) {
            throw new k_PageNotFound();
        }
        return parent::dispatch();
    }

    function renderHtml()
    {
        $tilmelding = VIH_Model_LangtKursus_Tilmelding::factory($this->name());

        if (strtolower($tilmelding->get('status')) == 'undervejs') {
            if (!$tilmelding->get('session_id')) {
                $tilmelding->setSessionId();
            }
            throw new Exception('Tilmeldingen er ikke fuldendt. <a href="'.$this->url('/langekurser/tilmelding/'.$tilmelding->get('session_id')).'">Fuldend tilmeldingen!</a>');
        } elseif (strtolower($tilmelding->get('status')) == 'slettet') {
            throw new Exception('Tilmeldingen er slettet. Ring til Vejle Idrætshøjskole, hvis det er en fejl.');
        }

        $tilmelding->loadBetaling();

        $opl_data = array('tilmelding' => $tilmelding,
                      'caption' => 'Tilmeldingsoplysninger');

        $pris_data = array('tilmelding' => $tilmelding);
        $tpl = $this->template->create('LangtKursus/Tilmelding/oplysninger');

        $oversigt_data = array('tilmelding' => $tilmelding,
                               'oplysninger' => $tpl->render($this, $opl_data),
                               'betalinger' => '');

        if ($tilmelding->antalRater() > 0) {
            $tpl = $this->template->create('LangtKursus/Tilmelding/prisoversigt');
            $oversigt_data['prisoversigt']  = $tpl->render($this, $pris_data);
        } else {
            $oversigt_data['prisoversigt'] = '<p class="notice"><strong>Priser</strong><br />Foreløbig skylder du '.$tilmelding->get('pris_tilmeldingsgebyr').' kroner. Den resterende pris kan du se, når vi har oprettet dine betalingsrater.</p>';
        }

        $this->document->setTitle('Tilmelding #' . $tilmelding->get('id'));
        $tpl = $this->template->create('Kundelogin/langekurser');
        return $tpl->render($this, $oversigt_data);
    }
}
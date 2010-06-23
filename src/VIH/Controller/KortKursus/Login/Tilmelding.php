<?php
class VIH_Controller_KortKursus_Login_Tilmelding extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $tilmelding = VIH_Model_KortKursus_Tilmelding::factory($this->name());
        if (!is_object($tilmelding) OR !$tilmelding->get('id')) {
            throw new Exception('Der findes ikke nogen tilmelding');
        }

        if (!$tilmelding->loadBetaling()) {
            throw new Exception('Kunne ikke loade betaling');
        }

        if (strtolower($tilmelding->get('status')) == 'slettet') {
            throw new Exception('Denne ordre er slettet. Ring til 75820811, hvis det er en fejl.');
        }

        $opl_data = array('caption' => 'Tilmeldingsoplysninger',
                          'tilmelding' => $tilmelding);

        $delt_data = array('deltagere' => $tilmelding->getDeltagere(),
                           'type' => $tilmelding->get('keywords'),
                           'kursus' => $tilmelding->kursus);

        $betal_data= array('tilmelding' => $tilmelding);

        $opl_tpl = $this->template->create('KortKursus/Tilmelding/oplysninger');
        $delt_tpl = $this->template->create('KortKursus/Tilmelding/deltagere');
        $bet_tpl = $this->template->create('KortKursus/Tilmelding/prisoversigt');

        $oversigt_data = array('tilmelding' => $tilmelding,
                               'oplysninger' => $opl_tpl->render($this, $opl_data),
                               'deltagere' => $delt->render($this, $delt_data),
                               'betalinger' => $bet_tpl->render($this, $betal_data));

        $this->document->setTitle('Tilmelding #' . $tilmelding->get('id'));
        $tpl = $this->template->create('Kundelogin/kortekurser');
        return $tpl->render($this, $oversigt_data);
    }

    function map($name)
    {
        if ($name == 'onlinebetaling') {
            return 'VIH_Controller_KortKursus_Login_OnlineBetaling';
        }
    }
}
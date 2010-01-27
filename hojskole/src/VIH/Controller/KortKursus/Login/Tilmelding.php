<?php
class VIH_Controller_KortKursus_Login_Tilmelding extends k_Controller
{
    function GET()
    {
        $tilmelding = VIH_Model_KortKursus_Tilmelding::factory($this->name);
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

        $oversigt_data = array('tilmelding' => $tilmelding,
                               'oplysninger' => $this->render('VIH/View/KortKursus/Tilmelding/oplysninger-tpl.php', $opl_data),
                               'deltagere' => $this->render('VIH/View/KortKursus/Tilmelding/deltagere-tpl.php', $delt_data),
                               'betalinger' => $this->render('VIH/View/KortKursus/Tilmelding/prisoversigt-tpl.php', $betal_data));

        $this->document->title = 'Tilmelding #' . $tilmelding->get('id');
        return $this->render('VIH/View/Kundelogin/kortekurser-tpl.php', $oversigt_data);
    }

    function forward($name)
    {
        if ($name == 'onlinebetaling') {
            $next = new VIH_Controller_KortKursus_Login_OnlineBetaling($this, $name);
            return $next->handleRequest();
        }
    }
}
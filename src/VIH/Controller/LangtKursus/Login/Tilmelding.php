<?php
class VIH_Controller_LangtKursus_Login_Tilmelding extends k_Controller
{
    public $map = array(
        'onlinebetaling' => 'VIH_Controller_LangtKursus_Login_Onlinebetaling',
        'fag'            => 'VIH_Controller_LangtKursus_Login_Fag'
    );

    function GET()
    {
        $tilmelding = VIH_Model_LangtKursus_Tilmelding::factory($this->name);
        if (!is_object($tilmelding) OR !$tilmelding->get('id')) {
            // @todo might be better to throw 404
            throw new Exception('Der findes ikke nogen tilmelding');
        }

        if (strtolower($tilmelding->get('status')) == 'undervejs') {
            if (!$tilmelding->get('session_id')) {
                $tilmelding->setSessionId();
            }
            throw new Exception('Tilmeldingen er ikke fuldendt. <a href="'.url('/langekurser/tilmelding/'.$tilmelding->get('session_id')).'">Fuldend tilmeldingen!</a>');
        } elseif (strtolower($tilmelding->get('status')) == 'slettet') {
            throw new Exception('Tilmeldingen er slettet. Ring til Vejle Idrætshøjskole, hvis det er en fejl.');
        }

        $tilmelding->loadBetaling();

        $opl_data = array('tilmelding' => $tilmelding,
                      'caption' => 'Tilmeldingsoplysninger');

        $pris_data = array('tilmelding' => $tilmelding);

        $oversigt_data = array('tilmelding' => $tilmelding,
                               'oplysninger' => $this->render('VIH/View/LangtKursus/Tilmelding/oplysninger-tpl.php', $opl_data),
                               'betalinger' => '');

        if ($tilmelding->antalRater() > 0) {
            $oversigt_data['prisoversigt']  = $this->render('VIH/View/LangtKursus/Tilmelding/prisoversigt-tpl.php', $pris_data);
        } else {
            $oversigt_data['prisoversigt'] = '<p class="notice"><strong>Priser</strong><br />Foreløbig skylder du '.$tilmelding->get('pris_tilmeldingsgebyr').' kroner. Den resterende pris kan du se, når vi har oprettet dine betalingsrater.</p>';
        }

        $this->document->title = 'Tilmelding #' . $tilmelding->get('id');
        return $this->render('VIH/View/Kundelogin/langekurser-tpl.php', $oversigt_data);
    }

}
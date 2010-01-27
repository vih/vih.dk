<?php
class VIH_Controller_LangtKursus_Login_Help
{
    function GET()
    {
        $tilmelding = VIH_Model_KortKursus_Tilmelding::factory($usr->getProperty('handle'));
        $tilmelding->loadBetaling();

        $data = array('login_uri' => KORTEKURSER_LOGIN_URI,
                      'tilmelding' => $tilmelding);

        
        $this->document->title = 'Tilmelding #' . $tilmelding->get('id');
        return '
            <h1>Hjælp</h1>
        ' . $this->render('VIH/View/tilmelding/betaling-tpl.php', $data);
    }
}
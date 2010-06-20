<?php
class VIH_Controller_KortKursus_Tilmelding_Confirm extends k_Controller
{
    private $form;

    function getForm()
    {
        if ($this->form) {
            return $this->form;
        }
        $form = new HTML_QuickForm('confirm', 'POST', $this->url());
        $form->addElement('header', null, 'Accepterer du betingelserne?');
        $form->addElement('checkbox', 'confirm', null, 'Ja, jeg accepterer betingelserne', 'id="confirm"');
        $form->addElement('submit', null, 'Send');

        $form->addRule('confirm', 'Du skal acceptere betingelserne', 'required');

        return ($this->form = $form);
    }

    function getTilmelding()
    {
        return new VIH_Model_KortKursus_OnlineTilmelding($this->context->name);
    }

    function GET()
    {
        $tilmelding = $this->getTilmelding();

        if (!$tilmelding->get('id') OR !$tilmelding->get('navn')) {
            throw new Exception('Du har ikke ret til at være her');
        }

        $tilmelding->loadPris();

        // Delete
        if (isset($_GET['delete']) AND is_numeric($_GET['delete'])) {
            $deltager = new VIH_Model_KortKursus_Tilmelding_Deltager($tilmelding, $_GET['delete']);
            $deltager->delete();
        }

        $this->document->title = 'Bekræft tilmeldingen';

        $deltager_data = array('deltagere' => $tilmelding->getDeltagere(),
                               'indkvartering' => $tilmelding->kursus->get('indkvartering'),
                               'type' => $tilmelding->get('keywords'),
                               'kursus' => $tilmelding->kursus);

        $oplysninger_data = array('caption' => 'Tilmeldingsoplysninger',
                                  'tilmelding' => $tilmelding);

        $tilmelding_data = array('headline' => 'Bekræft reservationen',
                                 'explanation' => '
            <p>Nu er du der næsten. Først skal du dog lige tjekke om oplysningerne er korrekte og godkende vores <a href="'.$this->url('../betingelser').'">betingelser</a>.</p>
        ' . $this->render('VIH/View/KortKursus/Tilmelding/oplysninger-tpl.php', $oplysninger_data) . $this->render('VIH/View/KortKursus/Tilmelding/deltagere-tpl.php', $deltager_data),
                                 'content' => $this->getForm()->toHTML());

        return $this->render('VIH/View/KortKursus/Tilmelding/tilmelding-tpl.php', $tilmelding_data);

    }

    function POST()
    {
        $tilmelding = $this->getTilmelding();

        if ($this->getForm()->validate()) {
            // confirm skal gemme en oplysning om, at kunden har konfirmeret betingelserne
            if ($this->POST['confirm']) {
                if (!$tilmelding->confirm()) {
                    throw new Exception('Kunne ikke bekræfte ordre ' . $tilmelding->get('id'));
                }
                if ($tilmelding->get('email')) {
                    $historik = new VIH_Model_Historik('kortekurser', $tilmelding->get('id'));
                    if (!$tilmelding->sendEmail()) {
                        if (!$historik->save(array('type' => 'kode', 'comment' => 'Bekræftelse på onlinetilmelding kunne ikke sendes'))) {
                            throw new Exception('Historikken kunne ikke gemmes');
                        }
                    } else {
                        if (!$historik->save(array('type' => 'kode', 'comment' => 'Bekræftelse på onlinetilmelding'))) {
                            throw new Exception('Historikken kunne ikke gemmes');
                        }
                    }
                }
                throw new k_http_Redirect($this->context->url('kvittering'));
            } else {
                throw new Exception('Ordren skal godkendes');
            }
        }
        throw new k_http_Redirect($this->url());

    }
}
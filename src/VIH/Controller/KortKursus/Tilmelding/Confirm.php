<?php
class VIH_Controller_KortKursus_Tilmelding_Confirm extends k_Component
{
    private $form;
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

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
        return new VIH_Model_KortKursus_OnlineTilmelding($this->context->name());
    }

    function dispatch()
    {
        $tilmelding = $this->getTilmelding();

        if (!$tilmelding->get('id') OR !$tilmelding->get('navn')) {
            throw new k_PageNotFound;
        }
        return parent::dispatch();
    }

    function renderHtml()
    {
        $tilmelding = $this->getTilmelding();
        $tilmelding->loadPris();

        // Delete
        if (isset($_GET['delete']) AND is_numeric($_GET['delete'])) {
            $deltager = new VIH_Model_KortKursus_Tilmelding_Deltager($tilmelding, $_GET['delete']);
            $deltager->delete();
        }

        $this->document->setTitle('Bekræft tilmeldingen');

        $deltager_data = array('deltagere' => $tilmelding->getDeltagere(),
                               'indkvartering' => $tilmelding->kursus->get('indkvartering'),
                               'type' => $tilmelding->get('keywords'),
                               'kursus' => $tilmelding->kursus);

        $oplysninger_data = array('caption' => 'Tilmeldingsoplysninger',
                                  'tilmelding' => $tilmelding);

        $tpl = $this->template->create('KortKursus/Tilmelding/oplysninger');
        $del_tpl = $this->template->create('KortKursus/Tilmelding/deltagere');

        $tilmelding_data = array('headline' => 'Bekræft reservationen',
                                 'explanation' => '
            <p>Nu er du der næsten. Først skal du dog lige tjekke om oplysningerne er korrekte og godkende vores <a href="'.$this->url('../betingelser').'">betingelser</a>.</p>
        ' . $tpl->render($this, $oplysninger_data) . $del_tpl->render($this, $deltager_data),
                                 'content' => $this->getForm()->toHTML());

        $tpl = $this->template->create('KortKursus/Tilmelding/tilmelding');

        return $tpl->render($this, $tilmelding_data);

    }

    function postForm()
    {
        $tilmelding = $this->getTilmelding();

        if ($this->getForm()->validate()) {
            // confirm skal gemme en oplysning om, at kunden har konfirmeret betingelserne
            if ($this->body('confirm')) {
                if (!$tilmelding->confirm()) {
                    throw new Exception('Kunne ikke bekræfte ordre ' . $tilmelding->get('id'));
                }
                if ($tilmelding->get('email')) {
                    $historik = new VIH_Model_Historik('kortekurser', $tilmelding->get('id'));
                    if (!$tilmelding->sendEmail()) {
                        if (!$historik->save(array('type' => 'kode', 'comment' => 'BekrÃ¦ftelse pÃ¥ onlinetilmelding kunne ikke sendes'))) {
                            throw new Exception('Historikken kunne ikke gemmes');
                        }
                    } else {
                        if (!$historik->save(array('type' => 'kode', 'comment' => 'BekrÃ¦ftelse pÃ¥ onlinetilmelding'))) {
                            throw new Exception('Historikken kunne ikke gemmes');
                        }
                    }
                }
                return new k_SeeOther($this->context->url('kvittering'));
            } else {
                throw new Exception('Ordren skal godkendes');
            }
        }
        return $this->render();
    }
}
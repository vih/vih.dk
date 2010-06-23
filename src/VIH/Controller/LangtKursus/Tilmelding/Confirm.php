<?php
class VIH_Controller_LangtKursus_Tilmelding_Confirm extends k_Component
{
    private $form;
    protected $template;
    protected $doctrine;

    function __construct(k_TemplateFactory $template, Doctrine_Connection_Common $doctrine)
    {
        $this->template = $template;
        $this->doctrine = $doctrine;
    }

    private function getForm()
    {
        if ($this->form) {
            return $this->form;
        }
        $this->form = new HTML_QuickForm('confirm', 'POST', $this->url());
        $this->form->addElement('checkbox', 'confirm', 'Accepterer du betingelserne?', 'Ja, jeg accepterer betingelserne', 'id="confirm_conditions"');
        $this->form->addElement('submit', null, 'Send');

        $this->form->addRule('confirm', 'Du skal acceptere betingelserne', 'required');
        return $this->form;
    }

    public function renderHtml()
    {
        $tilmelding = new VIH_Model_LangtKursus_OnlineTilmelding($this->context->name());

        if (!$tilmelding->getId()) {
            throw new Exception('Du har ikke adgang til at vï¿½re her');
        }

        $this->document->setTitle('Bekrï¿½ft reservation af plads');

        $data = array('tilmelding' => $tilmelding,
                      'caption' => 'Tilmeldingsoplysninger');

        $registration = Doctrine::getTable('VIH_Model_Course_Registration')->findOneBySessionId($this->context->name());

        $tpl = $this->template->create('LangtKursus/Tilmelding/oplysninger');

        return '
            <h1>Bekrï¿½ft reservationen</h1>
            <p>Nu er du der nï¿½sten. Fï¿½rst skal du lige tjekke om oplysningerne er korrekte, og sï¿½ skal du lige godkende vores betingelser.</p>
            ' .
            $tpl->render($this, $data) . $this->getForm()->toHTML();

    }

    public function POST()
    {
        $tilmelding = new VIH_Model_LangtKursus_OnlineTilmelding($this->context->name());

        if ($this->getForm()->validate()) {
            if (!$tilmelding->setStatus('tilmeldt')) {
                throw new Exception('Status kunne ikke sï¿½ttes');
            }

            if ($this->body('confirm')) {
                if (!$tilmelding->confirm()) {
                    throw new Exception('Tilmelding ' . $tilmelding->getId() . ' kunne ikke bekrï¿½ftes');
                }
                if ($tilmelding->get('email')) {
                    $historik = new VIH_Model_Historik('langekurser', $tilmelding->get('id'));
                    if (!$tilmelding->sendEmail()) {
                        if (!$historik->save(array('type' => 'kode', 'comment' => 'Bekrï¿½ftelse pï¿½ onlinetilmelding kunne ikke sendes'))) {
                            throw new Exception('Historikken kunne ikke gemmes');
                        }
                        throw new Exception('E-mailen kunne ikke sendes til ordre ' . $tilmelding->getId());
                    } else {
                        if (!$historik->save(array('type' => 'kode', 'comment' => 'Bekrï¿½ftelse pï¿½ onlinetilmelding'))) {
                            throw new Exception('Historikken kunne ikke gemmes');
                        }
                    }
                }
                return new k_SeeOther($this->context->url('kvittering'));
            }
        } else {
            return $this->getForm()->toHTML();
        }

        return $this->render();
    }
}

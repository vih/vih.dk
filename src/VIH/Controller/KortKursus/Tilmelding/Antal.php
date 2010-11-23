<?php
/**
 * Registration for short courses
 *
 * To start the registration we need to know:
 *
 * - what course
 * - number of participants
 *
 * If booking a fully booked course, you will be put on waiting list
 *
 * @author Lars Olesen <lars@legestue.net>
 */
class VIH_Controller_KortKursus_Tilmelding_Antal extends k_Component
{
    protected $form;
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function map($name)
    {
        if ($name == 'kontakt') {
            return 'VIH_Controller_KortKursus_Tilmelding_Kontakt';
        } elseif ($name == 'confirm') {
            return 'VIH_Controller_KortKursus_Tilmelding_Confirm';
        } elseif ($name == 'kvittering') {
            return 'VIH_Controller_KortKursus_Tilmelding_Kvittering';
        } elseif ($name == 'close') {
            return 'VIH_Controller_KortKursus_Tilmelding_Close';
        } elseif ($name == 'betingelser') {
            return 'VIH_Controller_KortKursus_Tilmelding_Betingelser';
        }
    }

    function renderHtml()
    {
        $tilmelding = $this->getTilmelding();

        $extra_text = '';
        if (is_numeric($this->query('kursus_id'))) {
            $kursus = new VIH_Model_KortKursus($this->query('kursus_id'));
            $kursus->getPladser();
            $kursus->getBegyndere();
            if ($kursus->get('pladser_ledige') <= 0):
                $extra_text = '<p class="alert">Der er ikke flere ledige pladser på '.$kursus->get('kursusnavn').'. Du kan blive skrevet på venteliste ved at klikke dig videre i formularen nedenunder, eller du kan vælge et andet kursus.</p>';
            elseif ($kursus->get('pladser_begyndere_ledige') <= 0 AND $kursus->get('gruppe_id') == 1): // golf
                $extra_text = '<p class="alert">Der er ikke flere ledige begynderpladser på '.$kursus->get('kursusnavn').'.</p>';
            endif;
        }

        $this->document->setTitle('Tilmelding til de korte kurser');

        $data = array('headline' => 'Tilmelding til korte kurser',
                      'explanation' => $extra_text. '
            <p>Du kan tilmelde dig de korte kurser ved at udfylde tilmeldingsformularen nedenunder.</p>
            <p class="notice"><strong>Vigtigt:</strong> Du angiver en kontaktperson pr. tilmelding. Det er kun kontaktpersonen, der får bekræftelser og program. Hvis I er flere, der ønsker at få post, beder vi jer lave flere tilmeldinger.</p>
        ',
                      'content' => $this->getForm()->toHTML());

        $tpl = $this->template->create('KortKursus/Tilmelding/tilmelding');
        return $tpl->render($this, $data);
    }

    function postForm()
    {
        $tilmelding = $this->getTilmelding();

        if ($this->getForm()->validate()) {
            $kursus = new VIH_Model_KortKursus($this->body('kursus_id'));
            $kursus->getPladser();

            if ($kursus->get('pladser_ledige') < $this->body('antal_deltagere')) {
                return new k_SeeOther($this->context->url('../venteliste'), array('antal' => $this->body('antal_deltagere')));
            }

            if ($tilmelding->start($this->body())) {
                $tilmelding->kursus->getPladser();
                if ($tilmelding->kursus->get('pladser_ledige') >= $this->body('antal_deltagere')) {
                    $deltagere = $tilmelding->getDeltagere();

                    if (count($deltagere) == 0) {
                        for ($i = 1; $i <= $this->body('antal_deltagere'); $i++) {
                            $deltager = new VIH_Model_KortKursus_Tilmelding_Deltager($tilmelding);
                            $deltager->add();
                        }
                    } elseif (count($deltagere) < $this->body('antal_deltagere')) {
                        for ($i = 1, $max = $this->body('antal_deltagere') - count($deltagere); $i <= $max; $i++) {
                            $deltager = new VIH_Model_KortKursus_Tilmelding_Deltager($tilmelding);
                            $deltager->add();
                        }
                    } elseif (count($deltagere) > $tilmelding->get('antal_deltagere')) {
                        // burde nok lave et tjek på, om nogle af dem er tomme?
                        for ($i = 1, $max = count($deltagere) - $this->body('antal_deltagere'); $i <= $max; $i++) {
                            $deltager = new VIH_Model_KortKursus_Tilmelding_Deltager($tilmelding, $deltagere[$i]->get('id'));
                            $deltager->delete();
                        }
                    }

                    return new k_SeeOther($this->url('kontakt'));
                }
            }
        }
        return $this->render();
    }

    function getTilmelding()
    {
        return new VIH_Model_KortKursus_OnlineTilmelding($this->name());
    }

    function getForm()
    {
        if ($this->form) {
            return $this->form;
        }

        $tilmelding = $this->getTilmelding();

        $kursus = new VIH_Model_KortKursus;
        $kurser = $kursus->getList();

        $kursus_list = array('' => 'Vælg');
        foreach ($kurser AS $kursus) {
            $kursus_id = $kursus->get('id');
            $kursus_navn = $kursus->get('kursusnavn') . ' ('.$kursus->get('pladser_status').')';
            $kursus_list[$kursus_id] = $kursus_navn;
        }

        $form = new HTML_QuickForm('kortekurser', 'POST', $this->url());
        $form->addElement('header', null, 'Hvilket kursus vil du tilmelde dig?');
        $form->addElement('select', 'kursus_id', 'Kursus', $kursus_list);
        $form->addElement('header', 'null', 'Hvor mange vil du tilmelde?');
        $form->addElement('select', 'antal_deltagere', 'Antal deltagere', array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10));
        $form->addElement('submit', null, 'Videre >>');

        $defaults = array();

        if ($tilmelding->get('kursus_id') > 0) {
            $defaults['kursus_id'] = $tilmelding->get('kursus_id');
            $defaults['antal_deltagere'] = count($tilmelding->getDeltagere());
        } else {
            $defaults['kursus_id'] = $this->context->getKursusId();
        }

        $form->setDefaults($defaults);

        $form->applyFilter('__ALL__', 'trim');
        $form->addRule('kursus_id', 'Du skal vælge et kursus', 'required');
        $form->addRule('kursus_id', 'Du skal vælge et kursus', 'numeric');
        $form->addRule('antal_deltagere', 'Du skal vælge hvor mange, du vil have', 'required');
        $form->addRule('antal_deltagere', 'Deltagerne skal være et tal', 'numeric');
        // $form->addRule('antal_deltagere', 'Du skal vælge flere end en deltager', 'range', array(1,10));

        return ($this->form = $form);
    }
}
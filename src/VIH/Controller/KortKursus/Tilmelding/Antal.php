<?php
/**
 * Tilmeldingssystem til Korte Kurser
 *
 * Denne side starter tilmeldingen op. Til det har vi brug for at vide fÃ¸lgende:
 *
 * - kursus vedkommende vil deltage pï¿½
 * - antallet af deltagere vedkommende vil tilmelde
 *
 * Man kan bï¿½de tilmelde sig kurser med og uden ledige pladser. Hvis man tilmelder
 * sig et kursus uden ledige pladser skal man kunne komme pï¿½ venteliste.
 *
 * @author Lars Olesen <lars@legestue.net>
 */

class VIH_Controller_KortKursus_Tilmelding_Antal extends k_Component
{
    private $form;

    public $map = array('kontakt'    => 'VIH_Controller_KortKursus_Tilmelding_Kontakt',
                        'confirm'    => 'VIH_Controller_KortKursus_Tilmelding_Confirm',
                        'kvittering' => 'VIH_Controller_KortKursus_Tilmelding_Kvittering');
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
                $extra_text = '<p class="alert">Der er ikke flere ledige pladser pï¿½ '.$kursus->get('kursusnavn').'. Du kan blive skrevet pï¿½ venteliste ved at klikke dig videre i formularen nedenunder, eller du kan vï¿½lge et andet kursus.</p>';
            elseif ($kursus->get('pladser_begyndere_ledige') <= 0 AND $kursus->get('gruppe_id') == 1): // golf
                $extra_text = '<p class="alert">Der er ikke flere ledige begynderpladser pï¿½ '.$kursus->get('kursusnavn').'.</p>';
            endif;
        }

        $this->document->setTitle('Tilmelding til de korte kurser');

        $data = array('headline' => 'Tilmelding til korte kurser',
                      'explanation' => $extra_text. '
            <p>Du kan tilmelde dig de korte kurser ved at udfylde tilmeldingsformularen nedenunder. Du kan se de trin, du skal igennem oppe i ï¿½verste hï¿½jre hjï¿½rne. Du kan ogsï¿½ ringe til hï¿½jskolen og fï¿½ en formular tilsendt med posten.</p>
            <p class="notice"><strong>Vigtigt:</strong> Du angiver en kontaktperson pr. tilmelding. Det er kun kontaktpersonen, der fï¿½r bekrï¿½ftelser og program. Hvis I er flere, der ï¿½nsker at fï¿½ post, beder vi jer lave flere tilmeldinger.</p>
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
                        for($i = 1; $i <= $this->body('antal_deltagere'); $i++) {
                            $deltager = new VIH_Model_KortKursus_Tilmelding_Deltager($tilmelding);
                            $deltager->add();
                        }
                    } elseif (count($deltagere) < $this->body('antal_deltagere')) {
                        for ($i = 1, $max = $this->body('antal_deltagere') - count($deltagere); $i <= $max; $i++) {
                            $deltager = new VIH_Model_KortKursus_Tilmelding_Deltager($tilmelding);
                            $deltager->add();
                        }
                    } elseif (count($deltagere) > $tilmelding->get('antal_deltagere')) {
                        // burde nok lave et tjek pï¿½, om nogle af dem er tomme?
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

        $kursus_list = array('' => 'Vï¿½lg');
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
        $form->addRule('kursus_id', 'Du skal vï¿½lge et kursus', 'required');
        $form->addRule('kursus_id', 'Du skal vï¿½lge et kursus', 'numeric');
        $form->addRule('antal_deltagere', 'Du skal vï¿½lge hvor mange, du vil have', 'required');
        $form->addRule('antal_deltagere', 'Deltagerne skal vï¿½re et tal', 'numeric');
        // $form->addRule('antal_deltagere', 'Du skal vï¿½lge flere end en deltager', 'range', array(1,10));

        return ($this->form = $form);
    }
}
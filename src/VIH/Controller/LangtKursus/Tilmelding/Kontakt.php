<?php
class VIH_Controller_LangtKursus_Tilmelding_Kontakt extends k_Component
{
    protected $form;

    function __construct(Doctrine_Connection_Common $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    function map($name)
    {
        if ($name == 'confirm') {
            return 'VIH_Controller_LangtKursus_Tilmelding_Confirm';
        } elseif ($name == 'kvittering') {
            return 'VIH_Controller_LangtKursus_Tilmelding_Kvittering';
        } elseif ($name == 'fag') {
            return 'VIH_Controller_LangtKursus_Tilmelding_Fag';
        } elseif ($name == 'close') {
            return 'VIH_Controller_LangtKursus_Tilmelding_Close';
        } elseif ($name == 'afbryd') {
            return 'VIH_Controller_LangtKursus_Tilmelding_Afbryd';
        }
    }

    function renderHtml()
    {
        $tilmelding = new VIH_Model_LangtKursus_OnlineTilmelding($this->name());

        if (!$tilmelding->start($this->context->getLangtKursusId())) {// denne kommando starter tilmeldingen
            throw new Exception('Tilmeldingen kan ikke startes');
        }

        $this->document->setTitle('Tilmelding til lange kurser');
        return '
            <h1>Ansøgning om optagelse</h2>
            <p>Du kan tilmelde dig via denne formular. Ved udfyldelse af denne formular accepterer du også vores <a href="'.$this->url('/langekurser/betalingsbetingelser').'">betalingsregler</a>. Din tilmelding er først gældende, når vi modtager tilmeldingsgebyr på 1000 kroner.</p>
        ' . $this->getForm()->toHTML();
    }

    function postForm()
    {
        $tilmelding = new VIH_Model_LangtKursus_OnlineTilmelding($this->name());

        if ($this->getForm()->validate()) {
            if ($tilmelding->save($this->body())) {
                if (!$tilmelding->setCode()) {
                    throw new Exception('Koden kunne ikke sættes');
                }
                return new k_SeeOther($this->url('fag'));
            }
        }

        return '<h1>Ansøgning om optagelse</h1><p>Der var fejl i formularen.</p>' . $this->getForm()->toHTML();
    }

    protected function getForm()
    {
        if ($this->form) {
            return $this->form;
        }

        $kurser = VIH_Model_LangtKursus::getList('åbne');

        $list = array();
        if ($this->query('kursus_id')) {
            $kursus_id = intval($this->query('kursus_id'));
        } else {
            $kursus_id = 0;
        }
        foreach ($kurser AS $kursus) {
            $list[$kursus->getId()] = $kursus->getKursusNavn() . ' som starter ' .$kursus->getDateStart()->format('%d-%m-%Y');
        }

        $tilmelding = new VIH_Model_LangtKursus_OnlineTilmelding($this->name());

        $this->form = new HTML_QuickForm('langekurser', 'POST', $this->url($this->subspace()));
        $this->form->addElement('header', null, 'Hvilket kursus vil du tilmelde dig?');
        $this->form->addElement('select', 'kursus_id', 'Kursus', $list);
        $this->form->addElement('header', null, 'Navn og adresse');
        $this->form->addElement('text', 'navn', 'Navn');
        $this->form->addElement('text', 'adresse', 'Adresse');
        $this->form->addElement('text', 'postnr', 'Postnummer');
        $this->form->addElement('text', 'postby', 'Postby');
        $this->form->addElement('text', 'cpr', 'Cpr-nummer');
        $this->form->addElement('text', 'telefonnummer', 'Telefonnummer');
        $this->form->addElement('text', 'kommune', 'Bopælskommune');
        $this->form->addElement('text', 'nationalitet', 'Nationalitet');
        $this->form->addElement('text', 'email', 'E-mail');
        $this->form->addElement('header', null, 'Nærmeste pårørende - hvem skal vi rette henvendelse til ved sygdom');
        $this->form->addElement('text', 'kontakt_navn', 'Navn');
        $this->form->addElement('text', 'kontakt_adresse', 'Adresse');
        $this->form->addElement('text', 'kontakt_postnr', 'Postnummer');
        $this->form->addElement('text', 'kontakt_postby', 'Postby');
        $this->form->addElement('text', 'kontakt_telefon', 'Telefon');
        $this->form->addElement('text', 'kontakt_arbejdstelefon', 'Arbejdstelefon');
        $this->form->addElement('text', 'kontakt_email', 'E-mail');
        $this->form->addElement('header', null, 'Hvordan er din uddannelsesmæssige baggrund?');
        foreach ($tilmelding->uddannelse AS $key=>$value) {
            $udd[] = &HTML_QuickForm::createElement('radio', null, null, $value, $key, 'id="uddannelse_'.$key.'"');
        }
        $this->form->addGroup($udd, 'uddannelse', 'Uddannelse');
        $this->form->addElement('header', null, 'Hvordan betaler du?');
        foreach ($tilmelding->betaling AS $key=>$value) {
            $bet[] = &HTML_QuickForm::createElement('radio', null, null, $value, $key, 'id="payment_' . $key.'"');
        }
        $this->form->addGroup($bet, 'betaling', 'Betaling');
        $this->form->addElement('header', null, 'Besked til Vejle Idrætshøjskole');

        $this->form->addElement('textarea', 'besked', 'Er der andet vi bør vide?', array('cols' => 50, 'rows' => 5));
        $this->form->addElement('submit', 'submit', 'Tilmelding');

        $defaults = array('navn' => $tilmelding->get('navn'),
                                 'adresse' => $tilmelding->get('adresse'),
                                 'cpr' => $tilmelding->get('cpr'),
                                 'telefonnummer' => $tilmelding->get('telefon'),
                                 'postnr' => $tilmelding->get('postnr'),
                                 'postby' => $tilmelding->get('postby'),
                                 'nationalitet' => $tilmelding->get('nationalitet'),
                                 'kommune' => $tilmelding->get('kommune'),
                                 'email' => $tilmelding->get('email'),
                                 'kontakt_navn' => $tilmelding->get('kontakt_navn'),
                                 'kontakt_adresse' => $tilmelding->get('kontakt_adresse'),
                                 'kontakt_postnr' => $tilmelding->get('kontakt_postnr'),
                                 'kontakt_postby' => $tilmelding->get('kontakt_postby'),
                                 'kontakt_telefon' => $tilmelding->get('kontakt_telefon'),
                                 'kontakt_arbejdstelefon' => $tilmelding->get('kontakt_arbejdstelefon'),
                                 'kontakt_email' => $tilmelding->get('kontakt_email'),
                                 'betaling' => $tilmelding->get('betaling_key'),
                                 'uddannelse' =>$tilmelding->get('uddannelse_key'),
                                 'besked' =>$tilmelding->get('besked'));

        if ($tilmelding->get('kursus_id') > 0) {
            $defaults['kursus_id'] = $tilmelding->get('kursus_id');
        } else {
            $defaults['kursus_id'] = $this->context->getLangtKursusId();
        }

        $this->form->setDefaults($defaults);
        $this->form->applyFilter('__ALL__', 'trim');
        $this->form->applyFilter('__ALL__', 'strip_tags');
        //$this->form->registerRule('validate_cpr', 'callback', 'validateCpr');
        $this->form->addRule('kursus_id', 'Du skal vælge et kursus', 'required');
        $this->form->addRule('kursus_id', 'Du skal vælge et kursus', 'numeric');
        $this->form->addRule('navn', 'Du skal skrive et navn', 'required');
        $this->form->addRule('adresse', 'Du skal skrive en adresse', 'required');
        $this->form->addRule('postnr', 'Postnummer', 'required');
        $this->form->addRule('postnr', 'Postnummer skal være numerisk', 'numeric');
        $this->form->addRule('postby', 'Postby', 'required');
        $this->form->addRule('telefonnummer', 'Telefonnummer', 'required');
        $this->form->addRule('email', 'Du har ikke skrevet en gyldig e-mail', 'email');
        $this->form->addRule('kommune', 'Du har ikke skrevet en kommune', 'required');
        $this->form->addRule('nationalitet', 'Du har ikke skrevet en nationalitet', 'required');
        $this->form->addRule('cpr', 'Du skal skrive et cpr-nummer', 'required');
        //$this->form->addRule('cpr', 'Du skal skrive et gyldigt cpr-nummer', 'validate_cpr');
        $this->form->addRule('kontakt_navn', 'Du har ikke skrevet et gyldigt kontaktnavn', 'required');
        $this->form->addRule('kontakt_adresse', 'Du har ikke skrevet et gyldig kontaktadresse', 'required');
        $this->form->addRule('kontakt_postnr', 'Du har ikke skrevet en kontaktpostnummer', 'required');
        $this->form->addRule('kontakt_postnr', 'Postnummeret skal være et tal', 'numeric');
        $this->form->addRule('kontakt_postby', 'Du har ikke skrevet en kontaktpostby', 'required');
        $this->form->addRule('kontakt_telefon', 'Du har ikke skrevet et nummer under telefon', 'required');
        $this->form->addRule('kontakt_arbejdstelefon', 'Du har ikke skrevet et nummer under arbejdstelefon', 'required');
        $this->form->addRule('kontakt_email', 'Du har ikke skrevet en gyldig kontakte-mail', 'email');
        $this->form->addGroupRule('uddannelse', 'Du skal vælge din uddannelsesmæssige baggrund', 'required', null);
        $this->form->addGroupRule('betaling', 'Du skal vælge, hvordan du betaler', 'required', null);
        return $this->form;
    }

    function getSubjects()
    {
        return $this->context->getSubjects();
    }
}
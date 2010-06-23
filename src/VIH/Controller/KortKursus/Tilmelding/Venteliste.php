<?php
class VIH_Controller_KortKursus_Tilmelding_Venteliste extends k_Component
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
        $form = new HTML_QuickForm('venteliste', 'POST', $this->url());
        $form->addElement('header', 'null', 'Hvor mange personer vil du s�tte p� venteliste?');
        $form->addElement('select', 'antal', 'Antal deltagere', array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10));
        $form->addElement('header', null, 'Din personlige oplysninger');
        $form->addElement('text', 'navn', 'Navn');
        /*
        $form->addElement('text', 'adresse', 'Adresse');
        $form->addElement('text', 'postnr', 'Postnr');
        $form->addElement('text', 'postby', 'By');
        */
        $form->addElement('text', 'email', 'E-mail');
        $form->addElement('text', 'arbejdstelefon', 'Telefon (ml. 8 og 16)');
        $form->addElement('text', 'telefonnummer', 'Alternativt telefonnummer');
        $form->addElement('textarea', 'besked', 'Besked');
        $form->addElement('submit', null, 'Send');

        $form->addRule("navn", "Du skal udfylde Navn", "required");
        //$form->addRule("adresse", "Du skal udfylde Adresse", "required");
        //$form->addRule("postnr", "Du skal udfylde Postnr", "required");
        //$form->addRule("postby", "Du skal udfylde By", "required");
        $form->addRule("arbejdstelefon", "Du skal udfylde telefon", "required");

        if (!empty($this->GET['antal']) AND is_numeric($this->GET['antal'])) {
            $form->setDefaults(array('antal'=>$this->GET['antal']));
        }

        return ($this->form = $form);
    }

    function dispatch()
    {
        $kursus = new VIH_Model_KortKursus($this->context->name());

        if ($kursus->getId() <= 0) {
            throw new Exception('Ikke gyldigt kursus_id');
        }
        return parent::dispatch();
    }

    function renderHtml()
    {
        $kursus = new VIH_Model_KortKursus($this->context->name());
        $this->document->setTitle('Venteliste');

        $venteliste = new VIH_Model_Venteliste(1, $this->context->name());

        if(intval($venteliste->get("kursus_id")) == 0) {
            throw new Exception("Ugyldigt kursus");
        }

        $data = array('content' => '<h1>Vil du p� venteliste?</h1><p class="notice">Der er ikke nok ledige pladser p� '.$kursus->get('kursusnavn').'. Vi kan tilbyde dig at komme p� venteliste, hvis du udfylder nedenst�ende kontaktinformationer.</p>' . $this->getForm()->toHTML());

        $tpl = $this->template->create('wrapper');
        return $tpl->render($this, $data);
    }

    function postForm()
    {
        $kursus = new VIH_Model_KortKursus($this->context->name());

        if ($this->getForm()->validate()) {

            $venteliste = new VIH_Model_Venteliste(1, $this->context->name());
            if(intval($venteliste->get("kursus_id")) == 0) {
                die("Ugyldigt kursus");
            }

            if ($venteliste->save($this->body())) {

                $number = $venteliste->getNumber();

                if(defined('EMAIL_STATUS') && EMAIL_STATUS == "online") {

                    $antal_personer = $venteliste->get("antal")." person";
                    if($venteliste->get("antal") > 1) {
                        $antal_personer .= "er";
                    }

                    $error = "";
                    $body = "K�re ".$this->body('navn')."\n\nDu er nu skrevet p� venteliste til kurset: ".$venteliste->get("kursusnavn").". Du er pt. nummer ".$number." p� ventelisten. Vi kontakter dig, hvis der bliver ledig plads til dig. �nsker du ikke l�ngere at st� p� ventelisten, m� du meget gerne kontakte os p� telefon 75820811 eller besvare denne e-mail.\n\nMed venlig hilsen\nVejle Idr�tsh�jskole";

                    $mailer = new VIH_Email;
                    $mailer->setSubject("Opskrivning p� venteliste");
                    $mailer->addAddress($this->body('email'), $this->body('navn'));
                    $mailer->setBody($body);

                    if ($mailer->send()) {
                        $emailsender = "<p>Du vil om kort tid modtage en e-mail med en bekr�ftelse p� at du er optaget p� ventelisten.</p><p>Med venlig hilsen<br />En venlig e-mail-robot<br />Vejle Idr�tsh�jskole</p>";
                    } else {
                        //trigger_error("Der er opst�et en fejl i email-senderen i forbindelse med opskrivning p� venteliste. Der er ikke sendt en bekr�ftelse til ".$this->getForm()->exportValue('navn'), E_USER_NOTICE);
                        $emailsender = "<p>Det var ikke muligt at sende dig en bekr�ftelse p� e-mail p� din optagelse p� venteliste. Har du sp�rgsm�l er du velkommen til at kontakte Vejle Idr�tsh�jskole. Imens tager vi lige en alvorlig snak med webmasteren.</p>";
                    }
                }

                $data = array('content' => '<h1>Du er optaget p� ventelisten!</h1><p>Du er nu optaget p� ventelisten til '.$kursus->get('kursusnavn').' med '.$venteliste->get("antal").' deltagere. Du st�r som nummer <strong>'.$number.'</strong> p� ventelisten.</p>'.$emailsender);
            } else {
                $data = array('content' => '
                    <h1>Fejl i indtastning!</h1>
                    <p>Der er fejl i de indtastede data, g� venligst tilbage og kontroller at de korrekte.</p>');

            }
        } else {
            $data = array('content' => '<h1>Vil du p� venteliste?</h1><p>Der var fejl i dine indtastninger.</p>' . $this->getForm()->toHTML());
        }

        $tpl = $this->template->create('wrapper');
        return $tpl->render($this, $data);
    }
}
